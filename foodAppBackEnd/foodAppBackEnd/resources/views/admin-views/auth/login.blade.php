<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{translate('Admin')}} | {{translate('Login')}}</title>

    @php($icon = \App\Model\BusinessSetting::where(['key' => 'fav_icon'])->first()?->value??'')
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/app/public/restaurant/' . $icon ?? '') }}">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/vendor/icon-set/style.css">

    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">
</head>

<body>
<main id="content" role="main" class="main">
    <div class="auth-wrapper">
        <div class="auth-wrapper-left">
            <div class="auth-left-cont">
                <img width="310" src="{{ $logo }}" alt="{{ translate('logo') }}">
                <h2 class="title">{{translate('your')}} <span class="c1 d-block text-capitalize">{{translate('Kitchen')}}</span> <strong class="text--039D55 c1 text-capitalize">{{translate('your_food')}}....</strong></h2>
            </div>
        </div>

        <div class="auth-wrapper-right">
            <div class="auth-wrapper-form">
                    <form class="" id="form-id" action="{{route('admin.auth.login')}}" method="post">
                        @csrf
                        <div class="auth-header">
                            <div class="mb-5">
                                <h2 class="title">{{translate('sign_in')}}</h2>
                                <div class="text-capitalize">{{translate('welcome_back')}}</div>
                                <p class="mb-0 text-capitalize">{{translate('want_to_login_your_branches')}}?
                                    <a href="{{route('branch.auth.login')}}">{{translate('branch_login')}}</a>
                                </p>
                                <span class="badge mt-2">( {{translate('admin_or_employee_sign_in')}} )</span>
                            </div>
                        </div>

                        <div class="js-form-message form-group">
                            <label class="input-label text-capitalize" for="signinSrEmail">{{translate('your')}} {{translate('email')}}</label>

                            <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail"
                                tabindex="1" placeholder="{{translate('email@address.com')}}" aria-label="email@address.com"
                                required data-msg="{{ translate('Please enter a valid email address') }}">
                        </div>

                        <div class="js-form-message form-group">
                            <label class="input-label" for="signupSrPassword" tabindex="0">
                                <span class="d-flex justify-content-between align-items-center">
                                {{translate('password')}}
                                </span>
                            </label>

                            <div class="input-group input-group-merge">
                                <input type="password" class="js-toggle-password form-control form-control-lg"
                                    name="password" id="signupSrPassword" placeholder="{{translate('8+ characters required')}}"
                                    aria-label="8+ characters required" required
                                    data-msg="{{ translate('Your password is invalid. Please try again.') }}"
                                    data-hs-toggle-password-options='{
                                        "target": "#changePassTarget",
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": "#changePassIcon"
                                        }'>
                                <div id="changePassTarget" class="input-group-append">
                                    <a class="input-group-text" href="javascript:">
                                        <i id="changePassIcon" class="tio-visible-outlined"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                    name="remember">
                                <label class="custom-control-label text-muted" for="termsCheckbox">
                                    {{translate('remember_me')}}
                                </label>
                            </div>
                        </div>

                        @php($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha'))
                        @if(isset($recaptcha) && $recaptcha['status'] == 1)
                            <div id="recaptcha_element" class="w-100" data-type="image"></div>
                            <br/>
                        @else
                            <div class="row p-2">
                                <div class="col-5 pr-0">
                                    <input type="text" class="form-control form-control-lg default-captcha-value" name="default_captcha_value" value=""
                                        placeholder="{{translate('Enter captcha value')}}" autocomplete="off">
                                </div>
                                <div class="col-7 input-icons" class="bg-white rounded">
                                    <a class="re-captcha">
                                        <img src="{{ URL('/admin/auth/code/captcha/1') }}" class="input-field default-recaptcha" id="default_recaptcha_id">
                                        <i class="tio-refresh icon"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-lg btn-block btn-primary">{{translate('sign_in')}}</button>
                    </form>

                @if(env('APP_MODE')=='demo')
                    <div class="border-top border-primary pt-5 mt-10">
                        <div class="row">
                            <div class="col-10">
                                <span>{{translate('Email : admin@admin.com')}}</span><br>
                                <span>{{translate('Password : 12345678')}}</span>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary px-3 copy-cred"><i class="tio-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>

<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        "use strict";

        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif

<script>
    "use strict";

    $(document).on('ready', function () {
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });

        $('.js-validate').each(function () {
            $.HSCore.components.HSValidation.init($(this));
        });

        $(".re-captcha").click(function() {
            re_captcha();
        });

        $(".copy-cred").click(function() {
            copy_cred();
        });
    });
</script>

@if(isset($recaptcha) && $recaptcha['status'] == 1)
    <script>
        "use strict";

        var onloadCallback = function () {
            grecaptcha.render('recaptcha_element', {
                'sitekey': '{{ \App\CentralLogics\Helpers::get_business_settings('recaptcha')['site_key'] }}'
            });
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script>
        "use strict";

        $("#form-id").on('submit',function(e) {
            var response = grecaptcha.getResponse();

            if (response.length === 0) {
                e.preventDefault();
                toastr.error("{{translate('Please check the recaptcha')}}");
            }
        });
    </script>
@else
    <script>
        "use strict";

        function re_captcha() {
            let $url = "{{ URL('/admin/auth/code/captcha') }}";
            $url = $url + "/" + Math.random();
            document.getElementById('default_recaptcha_id').src = $url;
            console.log('url: '+ $url);
        }
    </script>
@endif

@if(env('APP_MODE')=='demo')
    <script>
        "use strict";

        function copy_cred() {
            $('#signinSrEmail').val('admin@admin.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('{{\App\CentralLogics\translate("Copied successfully!")}}', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endif

<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>