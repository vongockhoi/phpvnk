<?php

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1', 'middleware' => ['verify.api']], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('sendOTP', 'AuthController@sendOTP');
    Route::post('verifyAccount', 'AuthController@verifyAccount');

    Route::group(['middleware' => ['auth:customer-api']], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('customer', 'AuthController@customer');
        Route::post('changePassword', 'AuthController@changePassword');
        Route::post('updateProfile', 'AuthController@updateProfile');

        Route::group(['prefix' => 'address', 'middleware' => []], function () {
            Route::get('getAddresses', 'AddressController@index');
            Route::get('getAddress', 'AddressController@show');
            Route::delete('removeAddresses', 'AddressController@destroy');
            Route::post('storeAddress', 'AddressController@store');
            Route::put('updateAddress', 'AddressController@update');
        });

        Route::group(['prefix' => 'area', 'middleware' => []], function () {
            Route::get('getProvinces', 'AreaController@getProvinces')->withoutMiddleware(['auth:customer-api']);
            Route::get('getDistricts', 'AreaController@getDistricts')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'base', 'middleware' => []], function () {
            Route::get('getDevices', 'BaseController@getDevices');
            Route::get('getVersionDetail', 'BaseController@getVersionDetail')->withoutMiddleware(['auth:customer-api']);
            Route::post('storeDevice', 'BaseController@storeDevice');
        });

        Route::group(['prefix' => 'carBooking', 'middleware' => []], function () {
            Route::post('storeCarBooking', 'CarBookingController@storeCarBooking')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'coupon', 'middleware' => []], function () {
            Route::get('getCoupons', 'CouponController@getCoupons')->withoutMiddleware(['auth:customer-api']);
            Route::get('getCoupon', 'CouponController@getCoupon')->withoutMiddleware(['auth:customer-api']);

            Route::get('getCouponsCustomer', 'CouponController@getCouponsCustomer');
            Route::get('getCouponCustomerDetail', 'CouponController@getCouponCustomerDetail');
            Route::get('getCouponsCustomerStatuses', 'CouponController@getCouponsCustomerStatuses')->withoutMiddleware(['auth:customer-api']);
            Route::get('getDiscountTypes', 'CouponController@getDiscountTypes')->withoutMiddleware(['auth:customer-api']);
            Route::get('getCouponTypes', 'CouponController@getCouponTypes')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'membership', 'middleware' => []], function () {
            Route::get('getMemberships', 'MembershipController@getMemberships')->withoutMiddleware(['auth:customer-api']);
            Route::get('getMembershipInfo', 'MembershipController@getMembershipInfo');
        });

        Route::group(['prefix' => 'customer', 'middleware' => []], function () {
            Route::get('init', 'CustomerController@init');
        });

        Route::group(['prefix' => 'message', 'middleware' => []], function () {
            Route::get('getMessages', 'MessageController@getMessages');
            Route::get('readMessage', 'MessageController@readMessage');
        });

        Route::group(['prefix' => 'order', 'middleware' => []], function () {
            Route::get('getCartDetail', 'OrderController@getCartDetail');
            Route::get('getOrders', 'OrderController@getOrders');
            Route::get('getOrderDetail', 'OrderController@getOrderDetail');
            Route::get('getOrderStatuses', 'OrderController@getOrderStatuses')->withoutMiddleware(['auth:customer-api']);
            Route::post('addToCart', 'OrderController@addToCart');
            Route::post('checkOutCart', 'OrderController@checkOutCart');
            Route::post('cancelOrder', 'OrderController@cancelOrder');
        });

        Route::group(['prefix' => 'product', 'middleware' => []], function () {
            Route::get('getProducts', 'ProductController@index')->withoutMiddleware(['auth:customer-api']);
            Route::get('getProduct', 'ProductController@show')->withoutMiddleware(['auth:customer-api']);
            Route::get('getProductStatusList', 'ProductController@getProductStatusList')->withoutMiddleware(['auth:customer-api']);
            Route::get('getProductCategoryList', 'ProductController@getProductCategoryList')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'restaurant', 'middleware' => []], function () {
            Route::get('getRestaurants', 'RestaurantController@index')->withoutMiddleware(['auth:customer-api']);
            Route::get('getRestaurantAll', 'RestaurantController@getRestaurantAll')->withoutMiddleware(['auth:customer-api']);
            Route::get('getRestaurantDetail', 'RestaurantController@show')->withoutMiddleware(['auth:customer-api']);
            Route::get('getRestaurantStatusList', 'RestaurantController@getRestaurantStatusList')->withoutMiddleware(['auth:customer-api']);
            Route::get('getProvinceList', 'RestaurantController@getProvinceList')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'home', 'middleware' => []], function () {
            Route::get('getHome', 'HomeController@getHome')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'reservation', 'middleware' => []], function () {
            Route::get('getReservations', 'ReservationController@getReservations');
            Route::get('getReservationStatus', 'ReservationController@getReservationStatus')->withoutMiddleware(['auth:customer-api']);
            Route::post('storeReservation', 'ReservationController@storeReservation')->withoutMiddleware(['auth:customer-api']);
        });

        Route::group(['prefix' => 'rating', 'middleware' => []], function () {
            Route::get('getRatings', 'RatingController@getRatings');
            Route::post('storeRating', 'RatingController@storeRating');
            Route::post('updateRating', 'RatingController@updateRating');
        });

    });
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::group(['prefix' => 'payment', 'middleware' => []], function() {
        Route::post('/listenCallback', 'Others\PaymentController@listenCallback');

//        Route::post('/createPaymentRequest', 'Others\PaymentController@createPaymentRequest'); // for TESTING api, not production
//        Route::post('/getPaymentResult', 'Others\PaymentController@getPaymentResult');
//        Route::post('/refund', 'Others\PaymentController@refund'); // for TESTING api, not production
    });
});

Route::group(['prefix' => 'v2', 'namespace' => 'Api\V2','middleware' => ['verify.api']], function () {
    Route::post('signIn', 'AuthController@signIn');
    Route::post('signUp', 'AuthController@signUp');
    Route::post('sendOTP', 'AuthController@sendOTP');
    Route::post('verifyOTP', 'AuthController@verifyOTP');

    Route::group(['middleware' => ['auth:customer-api']], function () {
        Route::get('signOut', 'AuthController@signOut');

    });
});

