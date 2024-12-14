<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\CustomerLogic;
use App\CentralLogics\Helpers;
use App\CentralLogics\OrderLogic;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\DeliveryHistory;
use App\Model\DeliveryMan;
use App\Model\Order;
use App\Models\OrderPartialPayment;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliverymanController extends Controller
{
    public function __construct(
        private DeliveryMan     $deliveryman,
        private Order           $order,
        private DeliveryHistory $deliveryHistory,
        private User            $user,
        private BusinessSetting $businessSetting

    )
    {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        return response()->json($deliveryman, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCurrentOrders(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $orders = $this->order
            ->with(['customer', 'order_partial_payments', 'delivery_address'])
            ->whereIn('order_status', ['pending', 'processing', 'out_for_delivery', 'confirmed', 'done', 'cooking'])
            ->where(['delivery_man_id' => $deliveryman['id']])
            ->get();

        return response()->json($orders, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function recordLocationData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $this->deliveryHistory->insert([
            'order_id' => $request['order_id'],
            'deliveryman_id' => $deliveryman['id'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],
            'time' => now(),
            'location' => $request['location'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['message' => translate('location recorded')], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getOrderHistory(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $history = $this->deliveryHistory->where(['order_id' => $request['order_id'], 'deliveryman_id' => $deliveryman['id']])->get();

        return response()->json($history, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateOrderStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'order_id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $this->order->where(['id' => $request['order_id'], 'delivery_man_id' => $deliveryman['id']])->update([
            'order_status' => $request['status']
        ]);

        $order = $this->order->find($request['order_id']);

        $customerFcmToken = null;
        $value = null;
        if($order->is_guest == 0){
            $customerFcmToken = $order->customer ? $order->customer->cm_firebase_token : null;
        }elseif($order->is_guest == 1){
            $customerFcmToken = $order->guest ? $order->guest->fcm_token : null;
        }

        $restaurantName = Helpers::get_business_settings('restaurant_name');
        $deliverymanName = $order->delivery_man ? $order->delivery_man->f_name. ' '. $order->delivery_man->l_name : '';
        $customerName = $order->is_guest == 0 ? ($order->customer ? $order->customer->f_name. ' '. $order->customer->l_name : '') : '';
        $local = $order->is_guest == 0 ? ($order->customer ? $order->customer->language_code : 'en') : 'en';;

        if ($request['status'] == 'out_for_delivery') {
            $message = Helpers::order_status_update_message('ord_start');

            if ($local != 'en'){
                $statusKey = Helpers::order_status_message_key('ord_start');
                $translatedMessage = $this->businessSetting->with('translations')->where(['key' => $statusKey])->first();
                if (isset($translatedMessage->translations)){
                    foreach ($translatedMessage->translations as $translation){
                        if ($local == $translation->locale){
                            $message = $translation->value;
                        }
                    }
                }
            }

            $value = Helpers::text_variable_data_format(value:$message, user_name: $customerName, restaurant_name: $restaurantName, delivery_man_name: $deliverymanName, order_id: $order->id);

        } elseif ($request['status'] == 'delivered') {
            if ($order->is_guest == 0){
                if ($order->user_id) CustomerLogic::create_loyalty_point_transaction($order->user_id, $order->id, $order->order_amount, 'order_place');

                if ($order->transaction == null) {
                    $ol = OrderLogic::create_transaction($order, 'admin');
                }

                $user = $this->user->find($order->user_id);
                $isFirstOrder = $this->order->where(['user_id' => $user->id, 'order_status' => 'delivered'])->count('id');
                $referredByUser = $this->user->find($user->refer_by);

                if ($isFirstOrder < 2 && isset($user->refer_by) && isset($referredByUser)) {
                    if ($this->businessSetting->where('key', 'ref_earning_status')->first()->value == 1) {
                        CustomerLogic::referral_earning_wallet_transaction($order->user_id, 'referral_order_place', $referredByUser->id);
                    }
                }
            }

            if ($order['payment_method'] == 'cash_on_delivery'){
                $partialData = OrderPartialPayment::where(['order_id' => $order->id])->first();
                if ($partialData){
                    $partial = new OrderPartialPayment;
                    $partial->order_id = $order['id'];
                    $partial->paid_with = 'cash_on_delivery';
                    $partial->paid_amount = $partialData->due_amount;
                    $partial->due_amount = 0;
                    $partial->save();
                }
            }

            $message = Helpers::order_status_update_message('delivery_boy_delivered');
            if ($local != 'en'){
                $statusKey = Helpers::order_status_message_key('delivery_boy_delivered');
                $translatedMessage = $this->businessSetting->with('translations')->where(['key' => $statusKey])->first();
                if (isset($translatedMessage->translations)){
                    foreach ($translatedMessage->translations as $translation){
                        if ($local == $translation->locale){
                            $message = $translation->value;
                        }
                    }
                }
            }

            $value = Helpers::text_variable_data_format(value:$message, user_name: $customerName, restaurant_name: $restaurantName, delivery_man_name: $deliverymanName, order_id: $order->id);
        }

        try {
            if ($value && $customerFcmToken != null) {
                $data = [
                    'title' => translate('Order'),
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                    'type' => 'order_status',
                ];
                Helpers::send_push_notif_to_device($customerFcmToken, $data);
            }

        } catch (\Exception $e) {

        }

        return response()->json(['message' => translate('Status updated')], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getOrderDetails(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $order = $this->order->with(['details'])->where(['delivery_man_id' => $deliveryman['id'], 'id' => $request['order_id']])->first();
        $details = isset($order->details) ? Helpers::order_details_formatter($order->details) : null;
        foreach ($details as $det) {
            $det['delivery_time'] = $order->delivery_time;
            $det['delivery_date'] = $order->delivery_date;
            $det['preparation_time'] = $order->preparation_time;
        }

        return response()->json($details, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllOrders(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $orders = $this->order
            ->with(['delivery_address', 'customer'])
            ->where(['delivery_man_id' => $deliveryman['id']])
            ->get();

        return response()->json($orders, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLastLocation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $lastData = $this->deliveryHistory
            ->where(['order_id' => $request['order_id']])
            ->latest()
            ->first();

        return response()->json($lastData, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function orderPaymentStatusUpdate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        if ($this->order->where(['delivery_man_id' => $deliveryman['id'], 'id' => $request['order_id']])->first()) {
            $this->order->where(['delivery_man_id' => $deliveryman['id'], 'id' => $request['order_id']])->update([
                'payment_status' => $request['status']
            ]);
            return response()->json(['message' => translate('Payment status updated')], 200);
        }

        return response()->json([
            'errors' => [
                ['code' => 'order', 'message' => translate('not found!')]
            ]
        ], 404);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateFcmToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();
        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $this->deliveryman->where(['id' => $deliveryman['id']])->update([
            'fcm_token' => $request['fcm_token'],
            'language_code' => $request->header('X-localization') ?? $deliveryman->language_code
        ]);

        return response()->json(['message' => translate('successfully updated!')], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function orderModel(Request $request): JsonResponse
    {
        $deliveryman = $this->deliveryman->where(['auth_token' => $request['token']])->first();

        if (!isset($deliveryman)) {
            return response()->json([
                'errors' => [
                    ['code' => 'delivery-man', 'message' => translate('Invalid token!')]
                ]
            ], 401);
        }

        $order = $this->order
            ->with(['customer', 'order_partial_payments'])
            ->whereIn('order_status', ['pending', 'processing', 'out_for_delivery', 'confirmed', 'done', 'cooking'])
            ->where(['delivery_man_id' => $deliveryman['id'], 'id' => $request->id])
            ->first();

        return response()->json($order, 200);
    }
}
