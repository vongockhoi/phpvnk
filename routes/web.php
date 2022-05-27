<?php

Route::redirect('/', '/login');
Route::get('/home', function() {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function() {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Status
    Route::delete('product-statuses/destroy', 'ProductStatusController@massDestroy')->name('product-statuses.massDestroy');
    Route::resource('product-statuses', 'ProductStatusController');

    // Province
    Route::delete('provinces/destroy', 'ProvinceController@massDestroy')->name('provinces.massDestroy');
    Route::resource('provinces', 'ProvinceController');

    // District
    Route::delete('districts/destroy', 'DistrictController@massDestroy')->name('districts.massDestroy');
    Route::resource('districts', 'DistrictController');
    Route::get('filterDistrictFromProvince', 'DistrictController@filterDistrictFromProvince')->name('districts.filterDistrictFromProvince');

    // Restaurant Status
    Route::delete('restaurant-statuses/destroy', 'RestaurantStatusController@massDestroy')->name('restaurant-statuses.massDestroy');
    Route::resource('restaurant-statuses', 'RestaurantStatusController');

    // Restaurant
    Route::delete('restaurants/destroy', 'RestaurantController@massDestroy')->name('restaurants.massDestroy');
    Route::post('restaurants/media', 'RestaurantController@storeMedia')->name('restaurants.storeMedia');
    Route::post('restaurants/ckmedia', 'RestaurantController@storeCKEditorImages')->name('restaurants.storeCKEditorImages');
    Route::resource('restaurants', 'RestaurantController');

    // Customer
    Route::delete('customers/destroy', 'CustomerController@massDestroy')->name('customers.massDestroy');
    Route::post('customers/media', 'CustomerController@storeMedia')->name('customers.storeMedia');
    Route::post('customers/ckmedia', 'CustomerController@storeCKEditorImages')->name('customers.storeCKEditorImages');
    Route::resource('customers', 'CustomerController');

    // Membership
    Route::delete('memberships/destroy', 'MembershipController@massDestroy')->name('memberships.massDestroy');
    Route::resource('memberships', 'MembershipController');

    // Coupon
    Route::delete('coupons/destroy', 'CouponController@massDestroy')->name('coupons.massDestroy');
    Route::post('coupons/media', 'CouponController@storeMedia')->name('coupons.storeMedia');
    Route::post('coupons/ckmedia', 'CouponController@storeCKEditorImages')->name('coupons.storeCKEditorImages');
    Route::resource('coupons', 'CouponController');

    // Coupon Type
    Route::delete('coupon-types/destroy', 'CouponTypeController@massDestroy')->name('coupon-types.massDestroy');
    Route::resource('coupon-types', 'CouponTypeController');

    // Discount Type
    Route::delete('discount-types/destroy', 'DiscountTypeController@massDestroy')->name('discount-types.massDestroy');
    Route::resource('discount-types', 'DiscountTypeController');

    // Coupon Status
    Route::delete('coupon-statuses/destroy', 'CouponStatusController@massDestroy')->name('coupon-statuses.massDestroy');
    Route::resource('coupon-statuses', 'CouponStatusController');

    // Point
    Route::delete('points/destroy', 'PointController@massDestroy')->name('points.massDestroy');
    Route::resource('points', 'PointController');

    // Cart
    Route::delete('carts/destroy', 'CartController@massDestroy')->name('carts.massDestroy');
    Route::resource('carts', 'CartController');

    // Cart Detail
    Route::delete('cart-details/destroy', 'CartDetailController@massDestroy')->name('cart-details.massDestroy');
    Route::resource('cart-details', 'CartDetailController');

    // Address
    Route::delete('addresses/destroy', 'AddressController@massDestroy')->name('addresses.massDestroy');
    Route::resource('addresses', 'AddressController');
    Route::get('filterAddressByCustomer', 'AddressController@filterAddressByCustomer')->name('addresses.filterAddressByCustomer');

    // Reservation Status
    Route::delete('reservation-statuses/destroy', 'ReservationStatusController@massDestroy')->name('reservation-statuses.massDestroy');
    Route::resource('reservation-statuses', 'ReservationStatusController');

    // Order
    Route::delete('orders/destroy', 'OrderController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrderController');
    Route::get('countNewOrder', 'OrderController@countNewOrder')->name("orders.countNewOrder");
    Route::post('calculateAmount', 'OrderController@calculateAmount')->name("orders.calculateAmount");
    Route::post('updateCustom', 'OrderController@updateCustom')->name("orders.updateCustom");

    // Order Status
    Route::delete('order-statuses/destroy', 'OrderStatusController@massDestroy')->name('order-statuses.massDestroy');
    Route::resource('order-statuses', 'OrderStatusController');

    // Order Detail
    Route::delete('order-details/destroy', 'OrderDetailController@massDestroy')->name('order-details.massDestroy');
    Route::resource('order-details', 'OrderDetailController');

    // Reservation
    Route::delete('reservations/destroy', 'ReservationController@massDestroy')->name('reservations.massDestroy');
    Route::resource('reservations', 'ReservationController');
    Route::get('countNewReservation', 'ReservationController@countNewReservation')->name("reservations.countNewReservation");

    // Coupon Customer Status
    Route::delete('coupon-customer-statuses/destroy', 'CouponCustomerStatusController@massDestroy')->name('coupon-customer-statuses.massDestroy');
    Route::resource('coupon-customer-statuses', 'CouponCustomerStatusController');

    // Coupon Customer
    Route::delete('coupon-customers/destroy', 'CouponCustomerController@massDestroy')->name('coupon-customers.massDestroy');
    Route::resource('coupon-customers', 'CouponCustomerController');

    // Restaurant Shipping Fee
    Route::delete('restaurant-shipping-fees/destroy', 'RestaurantShippingFeeController@massDestroy')->name('restaurant-shipping-fees.massDestroy');
    Route::resource('restaurant-shipping-fees', 'RestaurantShippingFeeController');

    // Operating Time
    Route::delete('operating-times/destroy', 'OperatingTimeController@massDestroy')->name('operating-times.massDestroy');
    Route::resource('operating-times', 'OperatingTimeController');

    // Banner
    Route::delete('banners/destroy', 'BannerController@massDestroy')->name('banners.massDestroy');
    Route::post('banners/media', 'BannerController@storeMedia')->name('banners.storeMedia');
    Route::post('banners/ckmedia', 'BannerController@storeCKEditorImages')->name('banners.storeCKEditorImages');
    Route::resource('banners', 'BannerController');

    // Rating
    Route::delete('ratings/destroy', 'RatingController@massDestroy')->name('ratings.massDestroy');
    Route::resource('ratings', 'RatingController');

    // Notification
    Route::delete('notifications/destroy', 'NotificationController@massDestroy')->name('notifications.massDestroy');
    Route::post('notifications/media', 'NotificationController@storeMedia')->name('notifications.storeMedia');
    Route::post('notifications/ckmedia', 'NotificationController@storeCKEditorImages')->name('notifications.storeCKEditorImages');
    Route::resource('notifications', 'NotificationController');

    // Car Booking
    Route::delete('car-bookings/destroy', 'CarBookingController@massDestroy')->name('car-bookings.massDestroy');
    Route::resource('car-bookings', 'CarBookingController');

    // Car Booking Status
    Route::delete('car-booking-statuses/destroy', 'CarBookingStatusController@massDestroy')->name('car-booking-statuses.massDestroy');
    Route::resource('car-booking-statuses', 'CarBookingStatusController');

    // Hash Tag
    Route::delete('hash-tags/destroy', 'HashTagController@massDestroy')->name('hash-tags.massDestroy');
    Route::resource('hash-tags', 'HashTagController');

    // Product Unit
    Route::delete('product-units/destroy', 'ProductUnitController@massDestroy')->name('product-units.massDestroy');
    Route::resource('product-units', 'ProductUnitController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');

    Route::post('updateMessageTokenFirebase', 'FirebaseController@updateMessageTokenFirebase')->name('updateMessageTokenFirebase');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function() {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
