<div class="card-header d-flex justify-content-between gap-10">
    <h5 class="mb-0"><?php echo e(translate('Most_Rated_Products')); ?></h5>
    <a href="<?php echo e(route('admin.reviews.list')); ?>" class="btn-link"><?php echo e(translate('View_All')); ?></a>
</div>

<div class="card-body">
    <div class="grid-item-wrap">
        <?php $__currentLoopData = $most_rated_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($product=\App\Model\Product::find($item['product_id'])); ?>
            <?php if(isset($product)): ?>
                <a class="grid-item text-dark" href='<?php echo e(route('admin.product.view',[$item['product_id']])); ?>'>
                    <div class="d-flex align-items-center gap-2">
                        <img class="rounded avatar"
                                src="<?php echo e($item->product->imageFullPath); ?>"
                                alt="<?php echo e($product->name); ?>-image">
                        <span class=" font-weight-semibold text-capitalize media-body">
                            <?php echo e(isset($product)?substr($product->name,0,18) . (strlen($product->name)>18?'...':''):'not exists'); ?>

                        </span>
                    </div>
                    <div>
                        <span class="rating text-primary"><i class="tio-star"></i></span>
                        <span><?php echo e($avgRating = count($product->rating)>0?number_format($product->rating[0]->average, 2, '.', ' '):0); ?> </span>
                        (<?php echo e($item['total']); ?>)
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/partials/_most-rated-products.blade.php ENDPATH**/ ?>