<div class="mb-5 mt-5">
    <ul class="nav nav-tabs border-0 mb-3">
        <li class="nav-item">
            <a class="nav-link <?php echo e(Request::is('admin/business-settings/web-app/system-setup/language*')? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.web-app.system-setup.language.index')); ?>">
                <?php echo e(translate('Language Setup')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(Request::is('admin/business-settings/web-app/system-setup/app-setting*')? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.web-app.system-setup.app_setting')); ?>">
                <?php echo e(translate('App Settings')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(Request::is('admin/business-settings/web-app/system-setup/firebase-message-config*')? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.web-app.system-setup.firebase_message_config_index')); ?>">
                <?php echo e(translate('Firebase Configuration')); ?>

            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(Request::is('admin/business-settings/web-app/system-setup/db-index*')? 'active' : ''); ?>"  href="<?php echo e(route('admin.business-settings.web-app.system-setup.db-index')); ?>">
                <?php echo e(translate('Clean Database')); ?>

            </a>
        </li>
    </ul>
</div>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/business-settings/partials/_system-settings-inline-menu.blade.php ENDPATH**/ ?>