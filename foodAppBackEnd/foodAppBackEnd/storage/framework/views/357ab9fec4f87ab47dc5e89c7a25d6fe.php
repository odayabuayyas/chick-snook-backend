<div class="card-header d-flex justify-content-between gap-10">
    <h5 class="mb-0"><?php echo e(translate('Top_Selling_Products')); ?></h5>
    <a href="<?php echo e(route('admin.product.list')); ?>" class="btn-link"><?php echo e(translate('View_All')); ?></a>
</div>

<div class="card-body">
    <div class="d-flex flex-column gap-3">
        <?php $__currentLoopData = $top_sell; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($item->product)): ?>
                <a class="d-flex justify-content-between align-items-center text-dark" href="<?php echo e(route('admin.product.view',[$item['product_id']])); ?>">
                    <div class="media align-items-center gap-2">
                        <img class="rounded avatar avatar-lg" src="<?php echo e($item->product->imageFullPath); ?>"  alt="<?php echo e($item->product->name); ?> image">
                        <span class="font-weight-semibold text-capitalize media-body"><?php echo e(substr($item->product['name'],0,18)); ?> <?php echo e(strlen($item->product['name'])>18?'...':''); ?></span>
                    </div>
                    <span class="px-2 py-1 badge-soft-c1 font-weight-bold fz-12 rounded lh-1"><?php echo e(translate('Sold : ')); ?><?php echo e($item['count']); ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/partials/_top-selling-products.blade.php ENDPATH**/ ?>