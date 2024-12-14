<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo e(translate('Error 404')); ?> | <?php echo e(\App\CentralLogics\Helpers::get_business_settings('restaurant_name')); ?></title>

    <?php ($icon = \App\Model\BusinessSetting::where(['key' => 'fav_icon'])->first()?->value??''); ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('storage/app/public/restaurant/' . $icon ?? '')); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/vendor/icon-set/style.css">

    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/theme.minc619.css?v=1.0">
</head>

<body>

<div class="container">
    <div class="footer-height-offset d-flex justify-content-center align-items-center flex-column">
        <div class="row align-items-sm-center w-100">
            <div class="col-sm-6">
                <div class="text-center text-sm-right mr-sm-4 mb-5 mb-sm-0">
                    <img class="w-60 w-sm-100 mx-auto"
                         src="<?php echo e(asset('public/assets/admin')); ?>/svg/illustrations/think.svg" alt="Image Description"
                         style="max-width: 15rem;">
                </div>
            </div>

            <div class="col-sm-6 col-md-4 text-center text-sm-left">
                <h1 class="display-1 mb-0">404</h1>
                <p class="lead"><?php echo e(translate('Sorry, the page you are looking for cannot be found.')); ?></p>
                <?php if(auth('branch')->check()): ?>
                    <a class="btn btn-primary" href="<?php echo e(route('branch.dashboard')); ?>"><?php echo e(translate('Dashboard')); ?></a>
                <?php else: ?>
                    <a class="btn btn-primary" href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(translate('Dashboard')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="footer text-center">
    <ul class="list-inline list-separator">
        <li class="list-inline-item">
            <a class="list-separator-link" target="_blank" href="<?php echo e(env('APP_MODE')=='demo'?'https://6amtech.com/':''); ?>"><?php echo e(\App\CentralLogics\Helpers::get_business_settings('restaurant_name')); ?> <?php echo e(translate('Support')); ?></a>
        </li>
    </ul>
</div>

<script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
</body>

</html>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/errors/404.blade.php ENDPATH**/ ?>