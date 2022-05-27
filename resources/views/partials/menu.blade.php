<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control">

            </select>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('banner_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.banners.index") }}"
                   class="c-sidebar-nav-link {{ request()->is("admin/banners") || request()->is("admin/banners/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-images c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.banner.title') }}
                </a>
            </li>
        @endcan
        @can('order_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/orders*") ? "c-show" : "" }} {{ request()->is("admin/order-details*") ? "c-show" : "" }} {{ request()->is("admin/order-statuses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-shipping-fast c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.orderManagement.title') }}
{{--                    <span id="count-new-order" class="@if(!empty($count_new_order)) badge badge-pill badge-danger @else @endif">{{ $count_new_order ?? "" }}</span>--}}
                    <span id="count-new-order" class=""></span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.orders.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.order.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('order_detail_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.order-details.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/order-details") || request()->is("admin/order-details/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.orderDetail.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('order_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.order-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/order-statuses") || request()->is("admin/order-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.orderStatus.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('reservation_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/reservations*") ? "c-show" : "" }} {{ request()->is("admin/reservation-statuses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-couch c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.reservationManagement.title') }}
{{--                    <span id="count-new-reservation" class="@if(!empty($count_new_reservation)) badge badge-pill badge-danger @else @endif">{{ $count_new_reservation ?? "" }}</span>--}}
                    <span id="count-new-reservation"></span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('reservation_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.reservations.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/reservations") || request()->is("admin/reservations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.reservation.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('reservation_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.reservation-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/reservation-statuses") || request()->is("admin/reservation-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.reservationStatus.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('car_booking_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/car-bookings*") ? "c-show" : "" }} {{ request()->is("admin/car-booking-statuses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.carBookingManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('car_booking_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.car-bookings.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/car-bookings") || request()->is("admin/car-bookings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carBooking.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('car_booking_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.car-booking-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/car-booking-statuses") || request()->is("admin/car-booking-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.carBookingStatus.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('cart_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/carts*") ? "c-show" : "" }} {{ request()->is("admin/cart-details*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.cartManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('cart_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.carts.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/carts") || request()->is("admin/carts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cart.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('cart_detail_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cart-details.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/cart-details") || request()->is("admin/cart-details/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.cartDetail.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('coupon_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/coupons*") ? "c-show" : "" }} {{ request()->is("admin/coupon-customers*") ? "c-show" : "" }} {{ request()->is("admin/coupon-types*") ? "c-show" : "" }} {{ request()->is("admin/coupon-statuses*") ? "c-show" : "" }} {{ request()->is("admin/discount-types*") ? "c-show" : "" }} {{ request()->is("admin/coupon-customer-statuses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-percent c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.couponManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('coupon_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.coupons.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/coupons") || request()->is("admin/coupons/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.coupon.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('coupon_customer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.coupon-customers.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/coupon-customers") || request()->is("admin/coupon-customers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.couponCustomer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('coupon_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.coupon-types.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/coupon-types") || request()->is("admin/coupon-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.couponType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('coupon_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.coupon-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/coupon-statuses") || request()->is("admin/coupon-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.couponStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('discount_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.discount-types.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/discount-types") || request()->is("admin/discount-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.discountType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('coupon_customer_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.coupon-customer-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/coupon-customer-statuses") || request()->is("admin/coupon-customer-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.couponCustomerStatus.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('customer_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/customers*") ? "c-show" : "" }} {{ request()->is("admin/memberships*") ? "c-show" : "" }} {{ request()->is("admin/points*") ? "c-show" : "" }} {{ request()->is("admin/addresses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-crown c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.customerManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('customer_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.customers.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/customers") || request()->is("admin/customers/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.customer.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('membership_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.memberships.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/memberships") || request()->is("admin/memberships/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.membership.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('point_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.points.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/points") || request()->is("admin/points/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.point.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('address_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.addresses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/addresses") || request()->is("admin/addresses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.address.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('restaurant_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/restaurants*") ? "c-show" : "" }} {{ request()->is("admin/restaurant-statuses*") ? "c-show" : "" }} {{ request()->is("admin/restaurant-shipping-fees*") ? "c-show" : "" }} {{ request()->is("admin/operating-times*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-store-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.restaurantManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('restaurant_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.restaurants.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/restaurants") || request()->is("admin/restaurants/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.restaurant.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('restaurant_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.restaurant-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/restaurant-statuses") || request()->is("admin/restaurant-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.restaurantStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('restaurant_shipping_fee_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.restaurant-shipping-fees.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/restaurant-shipping-fees") || request()->is("admin/restaurant-shipping-fees/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.restaurantShippingFee.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('operating_time_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.operating-times.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/operating-times") || request()->is("admin/operating-times/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.operatingTime.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('product_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/product-categories*") ? "c-show" : "" }} {{ request()->is("admin/product-statuses*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-utensils c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.productManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.product.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('product_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-categories.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/product-categories") || request()->is("admin/product-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.productCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('product_status_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-statuses.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/product-statuses") || request()->is("admin/product-statuses/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.productStatus.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('product_unit_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.product-units.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/product-units") || request()->is("admin/product-units/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.productUnit.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('rating_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.ratings.index") }}"
                   class="c-sidebar-nav-link {{ request()->is("admin/ratings") || request()->is("admin/ratings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-star-half-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.rating.title') }}
                </a>
            </li>
        @endcan
        @can('notification_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.notifications.index") }}"
                   class="c-sidebar-nav-link {{ request()->is("admin/notifications") || request()->is("admin/notifications/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.notification.title') }}
                </a>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/provinces*") ? "c-show" : "" }} {{ request()->is("admin/districts*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('province_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.provinces.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/provinces") || request()->is("admin/provinces/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.province.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('district_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.districts.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/districts") || request()->is("admin/districts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cog c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.district.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}"
                               class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('hash_tag_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.hash-tags.index") }}"
                   class="c-sidebar-nav-link {{ request()->is("admin/hash-tags") || request()->is("admin/hash-tags/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.hashTag.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}"
                       href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link"
               onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
