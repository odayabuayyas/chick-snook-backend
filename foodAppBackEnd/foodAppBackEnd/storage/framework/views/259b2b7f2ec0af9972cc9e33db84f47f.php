<div class="mt-5 mb-5">
    <div class="inline-page-menu my-4">
        <ul class="list-unstyled">
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/restaurant-setup')? 'active': ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.restaurant-setup')); ?>"><?php echo e(translate('Business_Settings')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/main-branch-setup')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.main-branch-setup')); ?>"><?php echo e(translate('Main_Branch_Setup')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/time-schedule')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.time_schedule_index')); ?>"><?php echo e(translate('Restaurant_Availabilty_Time_Slot')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/delivery-fee-setup')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.delivery-fee-setup')); ?>"><?php echo e(translate('Delivery_Fee_Setup')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/cookies-setup')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.cookies-setup')); ?>"><?php echo e(translate('Cookies Setup')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/otp-setup')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.otp-setup')); ?>"><?php echo e(translate('Login and OTP Setup')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/customer-settings')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.customer.settings')); ?>"><?php echo e(translate('Customers')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/order-index')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.order-index')); ?>"><?php echo e(translate('Orders')); ?></a></li>
            <li class="<?php echo e(Request::is('admin/business-settings/restaurant/qrcode-index')? 'active' : ''); ?>"><a href="<?php echo e(route('admin.business-settings.restaurant.qrcode-index')); ?>"><?php echo e(translate('QR Code')); ?></a></li>

        </ul>
    </div>
</div>
<?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/business-settings/partials/_business-setup-inline-menu.blade.php ENDPATH**/ ?>