<div class="card-header d-flex justify-content-between gap-10">
    <h5 class="mb-0"><?php echo e(translate('Top_Customer')); ?></h5>
    <a href="<?php echo e(route('admin.customer.list')); ?>" class="btn-link"><?php echo e(translate('View_All')); ?></a>
</div>

<div class="card-body">
    <div class="d-flex flex-column gap-3">
        <?php $__currentLoopData = $top_customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($item->customer)): ?>
                <a class="d-flex justify-content-between align-items-center text-dark" href='<?php echo e(route('admin.customer.view', [$item['user_id']])); ?>'>
                    <div class="media align-items-center gap-3">
                        <img class="rounded avatar avatar-lg"
                                src="<?php echo e($item->customer->imageFullPath); ?>">
                        <div class="media-body d-flex flex-column custom-media-body">
                            <span class="font-weight-semibold text-capitalize"><?php echo e($item->customer['f_name']??'Not exist'); ?></span>
                            <span class="text-dark"><?php echo e($item->customer['phone']?? translate('Not exist')); ?></span>
                        </div>
                    </div>
                    <span class="px-2 py-1 badge-soft-c1 font-weight-bold fz-12 rounded lh-1"><?php echo e(translate('Orders : ')); ?><?php echo e($item['count']); ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/partials/_top-customer.blade.php ENDPATH**/ ?>