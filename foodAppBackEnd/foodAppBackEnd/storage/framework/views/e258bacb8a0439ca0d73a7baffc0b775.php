
<div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('admin.orders.list',['pending'])); ?>" class="dashboard--card">
        <h5 class="dashboard--card__subtitle"><?php echo e(translate('pending')); ?></h5>
        <h2 class="dashboard--card__title"><?php echo e($data['pending']); ?></h2>
        <img width="30" src="<?php echo e(asset('public/assets/admin/img/icons/pending.png')); ?>" class="dashboard--card__img" alt="">
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('admin.orders.list',['confirmed'])); ?>" class="dashboard--card">
        <h5 class="dashboard--card__subtitle"><?php echo e(translate('confirmed')); ?></h5>
        <h2 class="dashboard--card__title"><?php echo e($data['confirmed']); ?></h2>
        <img width="30" src="<?php echo e(asset('public/assets/admin/img/icons/confirmed.png')); ?>" class="dashboard--card__img" alt="">
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('admin.orders.list',['processing'])); ?>" class="dashboard--card">
        <h5 class="dashboard--card__subtitle"><?php echo e(translate('processing')); ?></h5>
        <h2 class="dashboard--card__title"><?php echo e($data['processing']); ?></h2>
        <img width="30" src="<?php echo e(asset('public/assets/admin/img/icons/packaging.png')); ?>" class="dashboard--card__img" alt="">
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('admin.orders.list',['out_for_delivery'])); ?>" class="dashboard--card">
        <h5 class="dashboard--card__subtitle"><?php echo e(translate('out_for_delivery')); ?></h5>
        <h2 class="dashboard--card__title"><?php echo e($data['out_for_delivery']); ?></h2>
        <img width="30" src="<?php echo e(asset('public/assets/admin/img/icons/out_for_delivery.png')); ?>" class="dashboard--card__img" alt="">
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_pending" href="<?php echo e(route('admin.orders.list',['delivered'])); ?>">
        <div class="order-stats__content">
            <img width="20" src="<?php echo e(asset('public/assets/admin/img/icons/delivered.png')); ?>" class="order-stats__img" alt="">
            <h6 class="order-stats__subtitle"><?php echo e(__('messages.delivered')); ?></h6>
        </div>
        <span class="order-stats__title">
            <?php echo e($data['delivered']); ?>

        </span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_canceled" href="<?php echo e(route('admin.orders.list',['canceled'])); ?>">
        <div class="order-stats__content">
            <img width="20" src="<?php echo e(asset('public/assets/admin/img/icons/canceled.png')); ?>" class="order-stats__img" alt="">
            <h6 class="order-stats__subtitle"><?php echo e(translate('canceled')); ?></h6>
        </div>
        <span class="order-stats__title">
            <?php echo e($data['canceled']); ?>

        </span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_returned" href="<?php echo e(route('admin.orders.list',['returned'])); ?>">
        <div class="order-stats__content">
            <img width="20" src="<?php echo e(asset('public/assets/admin/img/icons/returned.png')); ?>" class="order-stats__img" alt="">
            <h6 class="order-stats__subtitle"><?php echo e(__('messages.returned')); ?></h6>
        </div>
        <span class="order-stats__title">
            <?php echo e($data['returned']); ?>

        </span>
    </a>
</div>
<div class="col-sm-6 col-lg-3">
    <a class="order-stats order-stats_failed" href="<?php echo e(route('admin.orders.list',['failed'])); ?>">
        <div class="order-stats__content">
            <img width="20" src="<?php echo e(asset('public/assets/admin/img/icons/failed_to_deliver.png')); ?>" class="order-stats__img" alt="">
            <h6 class="order-stats__subtitle"><?php echo e(translate('failed_to_deliver')); ?></h6>
        </div>
        <span class="order-stats__title">
            <?php echo e($data['failed']); ?>

        </span>
    </a>
</div>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/partials/_dashboard-order-stats.blade.php ENDPATH**/ ?>