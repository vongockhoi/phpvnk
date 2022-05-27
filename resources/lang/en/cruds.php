<?php

return [
    'userManagement'        => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'            => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role'                  => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user'                  => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                        => 'ID',
            'id_helper'                 => ' ',
            'name'                      => 'Name',
            'name_helper'               => ' ',
            'email'                     => 'Email',
            'email_helper'              => ' ',
            'email_verified_at'         => 'Email verified at',
            'email_verified_at_helper'  => ' ',
            'password'                  => 'Password',
            'password_helper'           => ' ',
            'roles'                     => 'Roles',
            'roles_helper'              => ' ',
            'remember_token'            => 'Remember Token',
            'remember_token_helper'     => ' ',
            'created_at'                => 'Created at',
            'created_at_helper'         => ' ',
            'updated_at'                => 'Updated at',
            'updated_at_helper'         => ' ',
            'deleted_at'                => 'Deleted at',
            'deleted_at_helper'         => ' ',
            'verified'                  => 'Verified',
            'verified_helper'           => ' ',
            'verified_at'               => 'Verified at',
            'verified_at_helper'        => ' ',
            'verification_token'        => 'Verification token',
            'verification_token_helper' => ' ',
            'restaurants'               => 'Restaurants',
            'restaurants_helper'        => ' ',
            'phone'                     => 'Phone',
            'phone_helper'              => ' ',
        ],
    ],
    'productManagement'     => [
        'title'          => 'Product Management',
        'title_singular' => 'Product Management',
    ],
    'product'               => [
        'title'          => 'Product',
        'title_singular' => 'Product',
        'product_list'   => 'Product list',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'price'                    => 'Price',
            'price_helper'             => ' ',
            'quantity'                 => 'Quantity',
            'quantity_helper'          => ' ',
            'avatar'                   => 'Avatar',
            'avatar_helper'            => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'category'                 => 'Category',
            'category_helper'          => ' ',
            'status'                   => 'Status',
            'status_helper'            => ' ',
            'featured_image'           => 'Featured Image',
            'featured_image_helper'    => ' ',
            'restaurant'               => 'Restaurant',
            'restaurant_helper'        => ' ',
            'description'              => 'Description',
            'description_helper'       => ' ',
            'price_discount'           => 'Price Discount',
            'price_discount_helper'    => ' ',
            'is_price_change'          => 'Price change',
            'is_price_change_helper'   => ' ',
            'hash_tag'                 => 'Hash Tag',
            'hash_tag_helper'          => ' ',
            'type'                     => 'Type',
            'type_helper'              => ' ',
            'preparation_time'         => 'Preparation Time',
            'preparation_time_helper'  => ' ',
            'brief_description'        => 'Brief Description',
            'brief_description_helper' => ' ',
            'product_unit_id'          => 'Product unit',
            'product_unit_id_helper'   => ' ',
        ],
    ],
    'productCategory'       => [
        'title'                 => 'Product Category',
        'title_singular'        => 'Product Category',
        'product_category_list' => 'Product category list',
        'fields'                => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'avatar'             => 'Avatar',
            'avatar_helper'      => ' ',
            'icon'               => 'Representative icons (icons)',
            'icon_helper'        => ' ',
        ],
    ],
    'productStatus'         => [
        'title'               => 'Product Status',
        'title_singular'      => 'Product Status',
        'product_status_list' => 'Product status list',
        'fields'              => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'restaurantManagement'  => [
        'title'          => 'Restaurant Management',
        'title_singular' => 'Restaurant Management',
    ],
    'setting'               => [
        'title'          => 'Setting',
        'title_singular' => 'Setting',
    ],
    'province'              => [
        'title'          => 'Province',
        'title_singular' => 'Province',
        'province_list'  => 'Province list',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'district'              => [
        'title'          => 'District',
        'title_singular' => 'District',
        'district_list'  => 'District list',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'province'          => 'Province',
            'province_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'restaurantStatus'      => [
        'title'                  => 'Restaurant Status',
        'title_singular'         => 'Restaurant Status',
        'restaurant_status_list' => 'Restaurant status list',
        'fields'                 => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'restaurant'            => [
        'title'           => 'Restaurant',
        'title_singular'  => 'Restaurant',
        'restaurant_list' => 'Restaurant list',
        'fields'          => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'name'                  => 'Name',
            'name_helper'           => ' ',
            'avatar'                => 'Avatar',
            'avatar_helper'         => ' ',
            'province'              => 'Province',
            'province_helper'       => ' ',
            'district'              => 'District',
            'district_helper'       => ' ',
            'address'               => 'Address',
            'address_helper'        => ' ',
            'status'                => 'Status',
            'status_helper'         => ' ',
            'latitude'              => 'Latitude',
            'latitude_helper'       => ' ',
            'longitude'             => 'Longitude',
            'longitude_helper'      => ' ',
            'featured_image'        => 'Featured Image',
            'featured_image_helper' => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'description'           => 'Description',
            'description_helper'    => ' ',
            'hotline'               => 'Hotline',
            'hotline_helper'        => ' ',
        ],
    ],
    'customerManagement'    => [
        'title'          => 'Customer Management',
        'title_singular' => 'Customer Management',
    ],
    'customer'              => [
        'title'          => 'Customer',
        'title_singular' => 'Customer',
        'customer_list'  => 'Customer list',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'full_name'         => 'Full Name',
            'full_name_helper'  => ' ',
            'first_name'        => 'First Name',
            'first_name_helper' => ' ',
            'last_name'         => 'Last Name',
            'last_name_helper'  => ' ',
            'birthday'          => 'Birthday',
            'birthday_helper'   => ' ',
            'phone'             => 'Phone',
            'phone_helper'      => ' ',
            'email'             => 'Email',
            'email_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'membership'        => 'Membership',
            'membership_helper' => ' ',
            'password'          => 'Password',
            'password_helper'   => ' ',
            'avatar'            => 'Avatar',
            'avatar_helper'     => ' ',
        ],
    ],
    'membership'            => [
        'title'           => 'Membership',
        'title_singular'  => 'Membership',
        'membership_list' => 'Membership list',
        'fields'          => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'name'                  => 'Name',
            'name_helper'           => ' ',
            'description'           => 'Description',
            'description_helper'    => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'discount_value'        => 'Discount Value',
            'discount_value_helper' => ' ',
        ],
    ],
    'couponManagement'      => [
        'title'          => 'Coupon Management',
        'title_singular' => 'Coupon Management',
    ],
    'coupon'                => [
        'title'          => 'Coupon',
        'title_singular' => 'Coupon',
        'coupon_list'    => 'Coupon list',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'name'                 => 'Name',
            'name_helper'          => ' ',
            'description'          => 'Description',
            'description_helper'   => ' ',
            'start_date'           => 'Start Date',
            'start_date_helper'    => ' ',
            'end_date'             => 'End Date',
            'end_date_helper'      => ' ',
            'restaurant'           => 'Restaurant',
            'restaurant_helper'    => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
            'coupon_type'          => 'Apply for',
            'coupon_type_helper'   => ' ',
            'value'                => 'Value',
            'value_helper'         => ' ',
            'discount_type'        => 'Discount Type',
            'discount_type_helper' => ' ',
            'status'               => 'Status',
            'status_helper'        => ' ',
            'code'                 => 'Code',
            'code_helper'          => ' ',
            'avatar'               => 'Avatar',
            'avatar_helper'        => ' ',
        ],
    ],
    'couponType'            => [
        'title'            => 'Coupon Type',
        'title_singular'   => 'Coupon Type',
        'coupon_type_list' => 'Coupon type list',
        'fields'           => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'discountType'          => [
        'title'              => 'Discount Type',
        'title_singular'     => 'Discount Type',
        'discount_type_list' => 'Discount type list',
        'fields'             => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'couponStatus'          => [
        'title'              => 'Coupon Status',
        'title_singular'     => 'Coupon Status',
        'coupon_status_list' => 'Coupon status list',
        'fields'             => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'point'                 => [
        'title'          => 'Point',
        'title_singular' => 'Point',
        'point_list'     => 'Point list',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'customer'            => 'Customer',
            'customer_helper'     => ' ',
            'num_of_point'        => 'Num Of Point',
            'num_of_point_helper' => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'reservationManagement' => [
        'title'          => 'Reservation Management',
        'title_singular' => 'Reservation Management',
    ],
    'cartManagement'        => [
        'title'          => 'Cart Management',
        'title_singular' => 'Cart Management',
    ],
    'cart'                  => [
        'title'          => 'Cart',
        'title_singular' => 'Cart',
        'cart_list'      => 'Cart list',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => ' ',
            'customer'               => 'Customer',
            'customer_helper'        => ' ',
            'created_at'             => 'Created at',
            'created_at_helper'      => ' ',
            'updated_at'             => 'Updated at',
            'updated_at_helper'      => ' ',
            'deleted_at'             => 'Deleted at',
            'deleted_at_helper'      => ' ',
            'total_price'            => 'Total Price',
            'total_price_helper'     => ' ',
            'address'                => 'Address',
            'address_helper'         => ' ',
            'coupon_customer'        => 'Coupon Customer',
            'coupon_customer_helper' => ' ',
        ],
    ],
    'cartDetail'            => [
        'title'            => 'Cart Detail',
        'title_singular'   => 'Cart Detail',
        'cart_detail_list' => 'Cart detail list',
        'fields'           => [
            'id'                             => 'ID',
            'id_helper'                      => ' ',
            'product'                        => 'Product',
            'product_helper'                 => ' ',
            'quantity'                       => 'Quantity',
            'quantity_helper'                => ' ',
            'created_at'                     => 'Created at',
            'created_at_helper'              => ' ',
            'updated_at'                     => 'Updated at',
            'updated_at_helper'              => ' ',
            'deleted_at'                     => 'Deleted at',
            'deleted_at_helper'              => ' ',
            'cart'                           => 'Cart',
            'cart_helper'                    => ' ',
            'note'                           => 'Note',
            'note_helper'                    => ' ',
            'free_one_product_parent'        => 'Free One Product Parent',
            'free_one_product_parent_helper' => ' ',
        ],
    ],
    'address'               => [
        'title'          => 'Address',
        'title_singular' => 'Address',
        'address_list'   => 'Address list',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'province'          => 'Province',
            'province_helper'   => ' ',
            'district'          => 'District',
            'district_helper'   => ' ',
            'address'           => 'Address',
            'address_helper'    => ' ',
            'note'              => 'Note',
            'note_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'customer'          => 'Customer',
            'customer_helper'   => ' ',
            'is_default'        => 'Is Default',
            'is_default_helper' => ' ',
        ],
    ],
    'reservationStatus'     => [
        'title'                   => 'Reservation Status',
        'title_singular'          => 'Reservation Status',
        'reservation_status_list' => 'Reservation status list',
        'fields'                  => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created time',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'orderManagement'       => [
        'title'          => 'Order Management',
        'title_singular' => 'Order Management',
    ],
    'order'                 => [
        'title'          => 'Order',
        'title_singular' => 'Order',
        'order_list'     => 'Order list',
        'order_create'   => 'Create Order',
        'fields'         => [
            'id'                     => 'ID',
            'id_helper'              => ' ',
            'code'                   => 'Code',
            'code_helper'            => ' ',
            'customer'               => 'Customer',
            'customer_helper'        => ' ',
            'total_price'            => 'Total Price',
            'total_price_helper'     => ' ',
            'created_at'             => 'Created time',
            'created_at_helper'      => ' ',
            'updated_at'             => 'Updated at',
            'updated_at_helper'      => ' ',
            'deleted_at'             => 'Deleted at',
            'deleted_at_helper'      => ' ',
            'status'                 => 'Status',
            'status_helper'          => ' ',
            'reservation'            => 'Reservation',
            'reservation_helper'     => ' ',
            'address'                => 'Address',
            'address_helper'         => ' ',
            'is_prepay'              => 'Is Prepay',
            'is_prepay_helper'       => ' ',
            'coupon_customer'        => 'Coupon Customer',
            'coupon_customer_helper' => ' ',
            'is_delivery'            => 'Delivery',
            'is_delivery_helper'     => ' ',
            'restaurant'             => 'Restaurant',
            'restaurant_helper'      => ' ',
        ],
    ],
    'orderStatus'           => [
        'title'             => 'Order Status',
        'title_singular'    => 'Order Status',
        'order_status_list' => 'Order status list',
        'fields'            => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'orderDetail'           => [
        'title'             => 'Order Detail',
        'title_singular'    => 'Order Detail',
        'order_detail_list' => 'Order detail list',
        'fields'            => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'code'                     => 'Code',
            'code_helper'              => ' ',
            'customer'                 => 'Customer',
            'customer_helper'          => ' ',
            'customer_phone'           => 'Customer phone',
            'customer_phone_helper'    => ' ',
            'restaurant'               => 'Restaurant',
            'restaurant_helper'        => ' ',
            'shipping_fee'             => 'Shipping fee',
            'shipping_fee_helper'      => ' ',
            'order'                    => 'Order',
            'order_helper'             => ' ',
            'product'                  => 'Product',
            'product_helper'           => ' ',
            'quantity'                 => 'Quantity',
            'quantity_helper'          => ' ',
            'note'                     => 'Note',
            'note_helper'              => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'total_cost'               => 'Total cost',
            'total_cost_helper'        => ' ',
            'promotion'                => 'Promotion',
            'promotion_helper'         => ' ',
            'amount_to_collect'        => 'Amount to collect',
            'amount_to_collect_helper' => ' ',
            'deposit'                  => 'Deposit amount',
            'deposit_helper'           => ' ',
            'deposit_placeholder'      => 'Enter the deposit amount',
            'deposited'                => 'Deposited',
            'deposited_helper'         => ' ',
        ],
    ],
    'reservation'           => [
        'title'            => 'Reservation',
        'title_singular'   => 'Reservation',
        'reservation_list' => 'reservation list',
        'fields'           => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'code'              => 'Code',
            'code_helper'       => ' ',
            'customer'          => 'Customer',
            'customer_helper'   => ' ',
            'restaurant'        => 'Restaurant',
            'restaurant_helper' => ' ',
            'date'              => 'Date',
            'date_helper'       => ' ',
            'time'              => 'Time',
            'time_helper'       => ' ',
            'slot'              => 'Slot',
            'slot_helper'       => ' ',
            'status'            => 'Status',
            'status_helper'     => ' ',
            'created_at'        => 'Created time',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'couponCustomerStatus'  => [
        'title'                       => 'Coupon Customer Status',
        'title_singular'              => 'Coupon Customer Status',
        'coupon_customer_status_list' => 'Coupon customer status list',
        'fields'                      => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'couponCustomer'        => [
        'title'                => 'Coupon Customer',
        'title_singular'       => 'Coupon Customer',
        'coupon_customer_list' => 'Coupon customer list',
        'fields'               => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'code'              => 'Code',
            'code_helper'       => ' ',
            'coupon'            => 'Coupon',
            'coupon_helper'     => ' ',
            'customer'          => 'Customer',
            'customer_helper'   => ' ',
            'status'            => 'Status',
            'status_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'restaurantShippingFee' => [
        'title'                        => 'Restaurant Shipping Fee',
        'title_singular'               => 'Restaurant Shipping Fee',
        'restaurant_shipping_fee_list' => 'Restaurant shipping fee list',
        'fields'                       => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'restaurant'          => 'Restaurant',
            'restaurant_helper'   => ' ',
            'district'            => 'District',
            'district_helper'     => ' ',
            'shipping_fee'        => 'Shipping Fee',
            'shipping_fee_helper' => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'operatingTime'         => [
        'title'               => 'Operating Time',
        'title_singular'      => 'Operating Time',
        'operating_time_list' => 'Operating time list',
        'fields'              => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'restaurant'        => 'Restaurant',
            'restaurant_helper' => ' ',
            'open_time'         => 'Open Time',
            'open_time_helper'  => ' ',
            'close_time'        => 'Close Time',
            'close_time_helper' => ' ',
            'monday'            => 'Monday',
            'monday_helper'     => ' ',
            'tuesday'           => 'Tuesday',
            'tuesday_helper'    => ' ',
            'wednesday'         => 'Wednesday',
            'wednesday_helper'  => ' ',
            'thursday'          => 'Thursday',
            'thursday_helper'   => ' ',
            'friday'            => 'Friday',
            'friday_helper'     => ' ',
            'saturday'          => 'Saturday',
            'saturday_helper'   => ' ',
            'sunday'            => 'Sunday',
            'sunday_helper'     => ' ',
            'day_off'           => 'Day Off',
            'day_off_helper'    => ' ',
            'time_off'          => 'Time Off',
            'time_off_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'banner'                => [
        'title'          => 'Banner',
        'title_singular' => 'Banner',
        'banner_list'    => 'Banner list',
        'banner_create'  => 'Create Banner',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'avatar'             => 'Avatar',
            'avatar_helper'      => ' ',
            'active'             => 'Active',
            'active_helper'      => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
            'type'               => 'Type',
            'type_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
        ],
    ],
    'rating'                => [
        'title'          => 'Rating',
        'title_singular' => 'Rating',
        'rating_list'    => 'Rating list',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'order'               => 'Order',
            'order_helper'        => ' ',
            'point_rating'        => 'Point Rating',
            'point_rating_helper' => ' ',
            'note'                => 'Note',
            'note_helper'         => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'notification'          => [
        'title'             => 'Notification',
        'title_singular'    => 'Notification',
        'notification_list' => 'Notification list',
        'fields'            => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'title'                => 'Title',
            'title_helper'         => ' ',
            'sub_title'            => 'Sub Title',
            'sub_title_helper'     => ' ',
            'content'              => 'Content',
            'content_helper'       => ' ',
            'target_type'          => 'Target Type',
            'target_type_helper'   => ' ',
            'target'               => 'Target',
            'target_helper'        => ' ',
            'schedule_time'        => 'Schedule Time',
            'schedule_time_helper' => ' ',
            'icon'                 => 'Icon',
            'icon_helper'          => ' ',
            'status'               => 'Status',
            'status_helper'        => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
        ],
    ],
    'carBooking'            => [
        'title'            => 'Car Booking',
        'title_singular'   => 'Car Booking',
        'car_booking_list' => 'Car booking list',
        'fields'           => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'fullname'             => 'Full name',
            'fullname_helper'      => ' ',
            'phone'                => 'Phone',
            'phone_helper'         => ' ',
            'pick_up_point'        => 'Pick Up Point',
            'pick_up_point_helper' => ' ',
            'destination'          => 'Destination',
            'destination_helper'   => ' ',
            'time'                 => 'Time',
            'time_helper'          => ' ',
            'created_at'           => 'Created at',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Updated at',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Deleted at',
            'deleted_at_helper'    => ' ',
            'status'               => 'Status',
            'status_helper'        => ' ',
        ],
    ],
    'carBookingManagement'  => [
        'title'          => 'Car Booking Management',
        'title_singular' => 'Car Booking Management',
    ],
    'carBookingStatus'      => [
        'title'                   => 'Car Booking Status',
        'title_singular'          => 'Car Booking Status',
        'car_booking_status_list' => 'Car booking status list',
        'fields'                  => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'hashTag'               => [
        'title'          => 'Hash Tag',
        'title_singular' => 'Hash Tag',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'productUnit'           => [
        'title'          => 'Product Unit',
        'title_singular' => 'Product Unit',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'Name',
            'name_helper'       => ' ',
            'type'              => 'Type',
            'type_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
];