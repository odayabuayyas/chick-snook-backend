<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\CentralLogics\SMS_module;
use App\Http\Controllers\Controller;
use App\Traits\SmsGateway;
use App\User;
use Carbon\CarbonInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function __construct(
        private User $user,
    ){}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function passwordResetRequest(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $customer = $this->user
            ->where(['email' => $request['email_or_phone']])
            ->orWhere('phone', 'like', "%{$request['email_or_phone']}%")
            ->first();

        $sendByPhone = Helpers::get_business_settings('phone_verification');

        if (isset($customer)) {
            $OTPIntervalTime = Helpers::get_business_settings('otp_resend_time') ?? 60; // seconds
            $passwordVerificationData = DB::table('password_resets')->where('email_or_phone', $request['email_or_phone'])->first();

            if(isset($passwordVerificationData) &&  Carbon::parse($passwordVerificationData->created_at)->DiffInSeconds() < $OTPIntervalTime){
                $time = $OTPIntervalTime - Carbon::parse($passwordVerificationData->created_at)->DiffInSeconds();

                $errors = [];
                $errors[] = [
                    'code' => 'otp',
                    'message' => translate('please_try_again_after_') . $time . ' ' . translate('seconds')
                ];

                return response()->json([
                    'errors' => $errors
                ], 403);
            }

            $token = (env('APP_MODE') == 'live') ? rand(100000, 999999) : 123456;

            DB::table('password_resets')->updateOrInsert(['email_or_phone' => $request['email_or_phone']], [
                'token' => $token,
                'created_at' => now(),
            ]);

            if ($sendByPhone) {
                $publishedStatus = 0;
                $paymentPublishedStatus = config('get_payment_publish_status');
                if (isset($paymentPublishedStatus[0]['is_published'])) {
                    $publishedStatus = $paymentPublishedStatus[0]['is_published'];
                }
                if($publishedStatus == 1){
                    $response = SmsGateway::send($customer['phone'], $token);
                }else{
                    $response = SMS_module::send($customer['phone'], $token);
                }
                return response()->json(['message' => $response], 200);
            }

            try {
                $emailServices = Helpers::get_business_settings('mail_config');
                $mailStatus = Helpers::get_business_settings('forget_password_mail_status_user');

                if(isset($emailServices['status']) && $emailServices['status'] == 1 && $mailStatus == 1){
                    Mail::to($customer['email'])->send(new \App\Mail\PasswordResetMail($token, $customer['f_name']. ' '. $customer['l_name'], $customer->language_code ));
                }

            } catch (\Exception $exception) {
                return response()->json(['errors' => [
                    ['code' => 'config-missing', 'message' => translate('Email configuration issue.')]
                ]], 400);
            }

            return response()->json(['message' => translate('Email sent successfully.')], 200);
        }

        return response()->json(['errors' => [
            ['code' => 'not-found', 'message' => translate('Customer not found!')]
        ]], 404);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
            'reset_token'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $maxOTPHit = Helpers::get_business_settings('maximum_otp_hit') ?? 5;
        $maxOTPHitTime = Helpers::get_business_settings('otp_resend_time') ?? 60;    // seconds
        $tempBlockTime = Helpers::get_business_settings('temporary_block_time') ?? 600;   // seconds

        $verify = DB::table('password_resets')->where(['token' => $request['reset_token'], 'email_or_phone' => $request['email_or_phone']])->first();

        if (isset($verify)) {
            if(isset($verify->temp_block_time ) && Carbon::parse($verify->temp_block_time)->DiffInSeconds() <= $tempBlockTime){
                $time = $tempBlockTime - Carbon::parse($verify->temp_block_time)->DiffInSeconds();

                $errors = [];
                $errors[] = ['code' => 'otp_block_time',
                    'message' => translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans()
                ];
                return response()->json([
                    'errors' => $errors
                ], 403);
            }

            return response()->json(['message' => translate("Token found, you can proceed")], 200);

        }else{
            $verificationData= DB::table('password_resets')->where('email_or_phone', $request['email_or_phone'])->first();

            if(isset($verificationData)){
                $time = $tempBlockTime - Carbon::parse($verificationData->temp_block_time)->DiffInSeconds();

                if(isset($verificationData->temp_block_time ) && Carbon::parse($verificationData->temp_block_time)->DiffInSeconds() <= $tempBlockTime){
                    $time= $tempBlockTime - Carbon::parse($verificationData->temp_block_time)->DiffInSeconds();

                    $errors = [];
                    $errors[] = [
                        'code' => 'otp_block_time',
                        'message' => translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans()
                    ];
                    return response()->json([
                        'errors' => $errors
                    ], 403);
                }

                if($verificationData->is_temp_blocked == 1 && Carbon::parse($verificationData->created_at)->DiffInSeconds() >= $tempBlockTime){
                    DB::table('password_resets')->updateOrInsert(['email_or_phone' => $request['email_or_phone']],
                        [
                            'otp_hit_count' => 0,
                            'is_temp_blocked' => 0,
                            'temp_block_time' => null,
                            'created_at' => now(),
                        ]);
                }

                if($verificationData->otp_hit_count >= $maxOTPHit &&  Carbon::parse($verificationData->created_at)->DiffInSeconds() < $maxOTPHitTime &&  $verificationData->is_temp_blocked == 0){

                    DB::table('password_resets')->updateOrInsert(['email_or_phone' => $request['email_or_phone']],
                        [
                            'is_temp_blocked' => 1,
                            'temp_block_time' => now(),
                            'created_at' => now(),
                        ]);

                    $errors = [];
                    $errors[] = [
                        'code' => 'otp_temp_blocked',
                        'message' => translate('Too_many_attempts')
                    ];
                    return response()->json([
                        'errors' => $errors
                    ], 405);
                }

            }

            DB::table('password_resets')->updateOrInsert(['email_or_phone' => $request['email_or_phone']],
                [
                    'otp_hit_count' => DB::raw('otp_hit_count + 1'),
                    'created_at' => now(),
                    'temp_block_time' => null,
                ]);
        }

        return response()->json(['errors' => [
            ['code' => 'invalid', 'message' => translate('Invalid token.')]
        ]], 400);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPasswordSubmit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required',
            'reset_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $data = DB::table('password_resets')
            ->where(['email_or_phone' => $request['email_or_phone']])
            ->where(['token' => $request['reset_token']])
            ->first();

        if (isset($data)) {
            if ($request['password'] == $request['confirm_password']) {
                $customer = $this->user
                    ->where(['email' => $request['email_or_phone']])
                    ->orWhere('phone', $request['email_or_phone'])
                    ->first();
                $customer->password = bcrypt($request['confirm_password']);
                $customer->save();

                DB::table('password_resets')
                    ->where(['email_or_phone' => $request['email_or_phone']])
                    ->where(['token' => $request['reset_token']])
                    ->delete();

                return response()->json(['message' => translate('Password changed successfully.')], 200);
            }

            return response()->json(['errors' => [
                ['code' => 'mismatch', 'message' => translate('Password did,t match!')]
            ]], 401);
        }

        return response()->json(['errors' => [
            ['code' => 'invalid', 'message' => translate('Invalid token.')]
        ]], 400);
    }
}
