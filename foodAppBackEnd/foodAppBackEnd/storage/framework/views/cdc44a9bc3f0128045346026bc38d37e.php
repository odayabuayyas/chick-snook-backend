<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Title -->
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Favicon -->

    <?php ($icon = \App\Model\BusinessSetting::where(['key' => 'fav_icon'])->first()->value??''); ?>
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('storage/app/public/restaurant/' . $icon ?? '')); ?>">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/vendor/icon-set/style.css">
    
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/owl.min.css')); ?>">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/style.css?v=1.0">
    <?php echo $__env->yieldPushContent('css_or_js'); ?>

    <script
        src="<?php echo e(asset('public/assets/admin')); ?>/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/toastr.css">
</head>

<body class="footer-offset">
    <div class="direction-toggle">
        <i class="tio-settings"></i>
        <span></span>
    </div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" style="display: none;">
                <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                    <img width="200" src="<?php echo e(asset('public/assets/admin/img/loader.gif')); ?>">
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Builder -->
<?php echo $__env->make('layouts.admin.partials._front-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- End Builder -->

<!-- JS Preview mode only -->
<?php echo $__env->make('layouts.admin.partials._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.admin.partials._sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- End Content -->

    <!-- Footer -->
    <?php echo $__env->make('layouts.admin.partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- End Footer -->

    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <center>
                                <h2 style="color: rgba(96,96,96,0.68)">
                                    <i class="tio-shopping-cart-outlined"></i> <?php echo e(translate('You have new order, Check Please.')); ?>

                                </h2>
                                <hr>
                                <button onclick="check_order()" class="btn btn-primary"><?php echo e(translate('Ok, let me check')); ?></button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-status-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-status-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-status-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-status-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-status-ok-button" class="btn btn-primary min-w-120" data-dismiss="modal" onclick="confirmStatusToggle()"><?php echo e(translate('Ok')); ?></button>
                            <button id="reset_btn" type="reset" class="btn btn-secondary min-w-120" data-dismiss="modal">
                                <?php echo e(translate("Cancel")); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/custom.js"></script>
<!-- JS Implementing Plugins -->

<?php echo $__env->yieldPushContent('script'); ?>

<!-- JS Front -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/vendor.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/sweet_alert.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/toastr.js"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/owl.min.js')); ?>"></script>
<?php echo Toastr::message(); ?>


<?php if($errors->any()): ?>
    <script>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        toastr.error('<?php echo e($error); ?>', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php endif; ?>
<!-- Toggle Direction Init -->
<script>
    $(document).on('ready', function(){

        $(".direction-toggle").on("click", function () {
            setDirection(localStorage.getItem("direction"));
        });

        function setDirection(direction) {
            if (direction == "rtl") {
                localStorage.setItem("direction", "ltr");
                $("html").attr('dir', 'ltr');
            $(".direction-toggle").find('span').text('Toggle RTL')
            } else {
                localStorage.setItem("direction", "rtl");
                $("html").attr('dir', 'rtl');
            $(".direction-toggle").find('span').text('Toggle LTR')
            }
        }

        if (localStorage.getItem("direction") == "rtl") {
            $("html").attr('dir', "rtl");
            $(".direction-toggle").find('span').text('Toggle LTR')
        } else {
            $("html").attr('dir', "ltr");
            $(".direction-toggle").find('span').text('Toggle RTL')
        }

    })
</script>
<!-- JS Plugins Init. -->
<script>
    // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
    // =======================================================
    var sidebar = $('.js-navbar-vertical-aside').hsSideNav();

    $(document).on('ready', function () {

        // BUILDER TOGGLE INVOKER
        // =======================================================
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
            $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });
        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });






        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $('.js-nav-tooltip-link').tooltip({boundary: 'window'})

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function (e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });


    });
</script>


<?php echo $__env->yieldPushContent('script_2'); ?>
<audio id="myAudio">
    <source src="<?php echo e(asset('public/assets/admin/sound/notification.mp3')); ?>" type="audio/mpeg">
</audio>

<script>
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }

    //File Upload
    $(window).on('load', function() {
        $(".upload-file__input").on("change", function () {
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            let img = $(this).siblings(".upload-file__img").find('img');

            reader.onload = function (e) {
            img.attr("src", e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
        });
    })
</script>
<script>
    <?php if(Helpers::module_permission_check('order_management')): ?>
        setInterval(function () {
            $.get({
                url: '<?php echo e(route('admin.get-restaurant-data')); ?>',
                dataType: 'json',
                success: function (response) {
                    let data = response.data;
                    if (data.new_order > 0) {
                        playAudio();
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                },
            });
        }, 10000);
    <?php endif; ?>

    function check_order() {
        location.href = '<?php echo e(route('admin.orders.list',['status'=>'all'])); ?>';
    }

    $('.route-alert').on('click', function (){
        let route = $(this).data('route');
        let message = $(this).data('message');
        route_alert(route, message)
    });

    function route_alert(route, message) {
        Swal.fire({
            title: '<?php echo e(translate("Are you sure?")); ?>',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate("No")); ?>',
            confirmButtonText:'<?php echo e(translate("Yes")); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = route;
            }
        })
    }

    $('.form-alert').on('click', function (){
        let id = $(this).data('id');
        let message = $(this).data('message');
        form_alert(id, message)
    });

    function form_alert(id, message) {
        Swal.fire({
            title: '<?php echo e(translate("Are you sure?")); ?>',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate("No")); ?>',
            confirmButtonText: '<?php echo e(translate("Yes")); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    }

    $('.redirect-url').change(function() {
        location.href=$(this).data('url');
    });

    $('.redirect-url-value').change(function() {
        var newPriority = $(this).val();
        var url = $(this).data('url') + newPriority;
        location.href=url;
    });
</script>

<script>
    function call_demo(){
        toastr.info('Update option is disabled for demo!', {
            CloseButton: true,
            ProgressBar: true
        });
    }

    $('.call-demo').click(function() {
        if ('<?php echo e(env('APP_MODE')); ?>' === 'demo') {
            call_demo();
        }
    });
</script>


<script>
    <?php if(env('APP_MODE')=='live'): ?>
    //Internet Status Check
    window.addEventListener('online', function() {
        toastr.success('<?php echo e(translate('Became online')); ?>');
    });
    window.addEventListener('offline', function() {
        toastr.error('<?php echo e(translate('Became offline')); ?>');
    });

    //Internet Status Check (after any event)
    document.body.addEventListener("click", function(event) {
        if(window.navigator.onLine === false) {
            toastr.error('<?php echo e(translate('You are in offline')); ?>');
            event.preventDefault();
        }
    }, false);
    <?php endif; ?>


</script>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
<script>

    $(".status-change").change(function() {
        var value = $(this).val();
        let url = $(this).data('url');
        status_change(this, url);
    });

    function status_change(t, url) {
        let checked = $(t).prop("checked");
        let status = checked === true ? 1 : 0;

        Swal.fire({
            title: 'Are you sure?',
            text: 'Want to change status',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FC6A57',
            cancelButtonColor: 'default',
            cancelButtonText: '<?php echo e(translate("No")); ?>',
            confirmButtonText: '<?php echo e(translate("Yes")); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    data: {
                        status: status
                    },
                    success: function (data, status) {
                        toastr.success("<?php echo e(translate('Status changed successfully')); ?>");
                    },
                    error: function (data) {
                        toastr.error("<?php echo e(translate('Status changed failed')); ?>");
                    }
                });
            }
            else if (result.dismiss) {
                if (status == 1) {
                    $(t).prop('checked', false);
                } else if (status == 0) {
                    $(t).prop('checked', true);
                }
                toastr.info("<?php echo e(translate("Status has not changed")); ?>");
            }
        });
    }

</script>

<script>
    let initialImages = [];
    $(window).on('load', function() {
        $("form").find('img').each(function (index, value) {
            initialImages.push(value.src);
        })
    })

    $(document).ready(function() {
        $('form').on('reset', function(e) {
            $("form").find('img').each(function (index, value) {
                $(value).attr('src', initialImages[index]);
            })
            $('.js-select2-custom').val(null).trigger('change');

        });
    });
</script>

    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF SHOW PASSWORD
            // =======================================================
            $('.js-toggle-password').each(function () {
                new HSTogglePassword(this).init()
            });

            // INITIALIZATION OF FORM VALIDATION
            // =======================================================
            $('.js-validate').each(function () {
                $.HSCore.components.HSValidation.init($(this));
            });
        });
    </script>

<script>
    $('[data-toggle="tooltip"]').parent('label').addClass('label-has-tooltip')
</script>

    <script>
        $('.blinkings').on('mouseover', ()=> $('.blinkings').removeClass('active'))
        $('.blinkings').addClass('open-shadow')
        setTimeout(() => {
            $('.blinkings').removeClass('active')
        }, 10000);
        setTimeout(() => {
            $('.blinkings').removeClass('open-shadow')
        }, 5000);
    </script>
    <script>
        $(function(){
            var owl = $('.single-item-slider');
            owl.owlCarousel({
                autoplay: false,
                items:1,
                onInitialized  : counter,
                onTranslated : counter,
                autoHeight: true,
                dots: true,
            });

            function counter(event) {
                var element   = event.target;         // DOM element, in this example .owl-carousel
                var items     = event.item.count;     // Number of items
                var item      = event.item.index + 1;     // Position of the current item

                // it loop is true then reset counter from 1
                if(item > items) {
                    item = item - items
                }
                $('.slide-counter').html(+item+"/"+items)
            }
        });
    </script>

    <script>

        function toogleStatusModal(e, toggle_id, on_image, off_image, on_title, off_title, on_message, off_message) {
            // console.log($('#'+toggle_id).is(':checked'));
            e.preventDefault();
            if ($('#'+toggle_id).is(':checked')) {
                $('#toggle-status-title').empty().append(on_title);
                $('#toggle-status-message').empty().append(on_message);
                $('#toggle-status-image').attr('src', "<?php echo e(asset('/public/assets/admin/img/modal')); ?>/"+on_image);
                $('#toggle-status-ok-button').attr('toggle-ok-button', toggle_id);
            } else {
                $('#toggle-status-title').empty().append(off_title);
                $('#toggle-status-message').empty().append(off_message);
                $('#toggle-status-image').attr('src', "<?php echo e(asset('/public/assets/admin/img/modal')); ?>/"+off_image);
                $('#toggle-status-ok-button').attr('toggle-ok-button', toggle_id);
            }
            $('#toggle-status-modal').modal('show');
        }

        function confirmStatusToggle() {

            var toggle_id = $('#toggle-status-ok-button').attr('toggle-ok-button');
            if ($('#'+toggle_id).is(':checked')) {
                $('#'+toggle_id).prop('checked', false);
                $('#'+toggle_id).val(0);
            } else {
                $('#'+toggle_id).prop('checked', true);
                $('#'+toggle_id).val(1);
            }
            // console.log($('#'+toggle_id+'_form'));
            console.log(toggle_id);
            $('#'+toggle_id+'_form').submit();

        }

        function checkMailElement(id) {
            console.log(id);
            if ($('.'+id).is(':checked')) {
                $('#'+id).show();
            } else {
                $('#'+id).hide();
            }
        }

        function change_mail_route(value) {
            if(value == 'user'){
                var url= '<?php echo e(url('/')); ?>/admin/business-settings/email-setup/'+value+'/new-order';
            }else if(value == 'dm'){
                var url= '<?php echo e(url('/')); ?>/admin/business-settings/email-setup/'+value+'/registration';
            }
            location.href = url;
        }


        function checkedFunc() {
            $('.switch--custom-label .toggle-switch-input').each( function() {
                if(this.checked) {
                    $(this).closest('.switch--custom-label').addClass('checked')
                }else {
                    $(this).closest('.switch--custom-label').removeClass('checked')
                }
            })
        }
        checkedFunc()
        $('.switch--custom-label .toggle-switch-input').on('change', checkedFunc)

    </script>


</body>
</html>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/layouts/admin/app.blade.php ENDPATH**/ ?>