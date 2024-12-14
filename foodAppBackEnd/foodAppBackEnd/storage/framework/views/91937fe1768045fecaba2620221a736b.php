<?php $__env->startSection('title', translate('Settings')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="<?php echo e(asset('public/assets/admin/img/icons/firebase.png')); ?>" alt="">
                <span class="page-header-title">
                    <?php echo e(translate('system_setup')); ?>

                </span>
            </h2>
        </div>

        <?php echo $__env->make('admin-views.business-settings.partials._system-settings-inline-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row gx-2 gx-lg-3">
            <?php ($data=\App\CentralLogics\Helpers::get_business_settings('firebase_message_config')); ?>
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.web-app.system-setup.firebase_message_config'):'javascript:'); ?>" method="post"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-body">
                            <?php if(isset($data)): ?>
                                <div class="form-group">
                                    <label><?php echo e(translate('API Key')); ?></label>
                                    <input type="text" placeholder="" class="form-control" name="apiKey"
                                        value="<?php echo e(env('APP_MODE')!='demo'?$data['apiKey']:''); ?>" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(translate('Auth Domain')); ?></label>
                                    <input type="text" class="form-control" name="authDomain" value="<?php echo e(env('APP_MODE')!='demo'?$data['authDomain']:''); ?>" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label><?php echo e(translate('Project ID')); ?></label>
                                    <input type="text" class="form-control" name="projectId" value="<?php echo e(env('APP_MODE')!='demo'?$data['projectId']:''); ?>" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label><?php echo e(translate('Storage Bucket')); ?></label>
                                    <input type="text" class="form-control" name="storageBucket" value="<?php echo e(env('APP_MODE')!='demo'?$data['storageBucket']:''); ?>" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(translate('Messaging Sender ID')); ?></label>
                                    <input type="text" placeholder="" class="form-control" name="messagingSenderId"
                                        value="<?php echo e(env('APP_MODE')!='demo'?$data['messagingSenderId']:''); ?>" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label><?php echo e(translate('App ID')); ?></label>
                                    <input type="text" placeholder="" class="form-control" name="appId"
                                        value="<?php echo e(env('APP_MODE')!='demo'?$data['appId']:''); ?>" required autocomplete="off">
                                </div>

                                <div class="btn--container">
                                    <button type="reset" class="btn btn-secondary"><?php echo e(translate('reset')); ?></button>
                                    <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"
                                            class="btn btn-primary call-demo"><?php echo e(translate('save')); ?></button>
                                </div>
                            <?php else: ?>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary"><?php echo e(translate('configure')); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/business-settings/firebase-config-index.blade.php ENDPATH**/ ?>