<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'product_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'product_create',
            ],
            [
                'id'    => 19,
                'title' => 'product_edit',
            ],
            [
                'id'    => 20,
                'title' => 'product_show',
            ],
            [
                'id'    => 21,
                'title' => 'product_delete',
            ],
            [
                'id'    => 22,
                'title' => 'product_access',
            ],
            [
                'id'    => 23,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 24,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 25,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 26,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 27,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 28,
                'title' => 'product_status_create',
            ],
            [
                'id'    => 29,
                'title' => 'product_status_edit',
            ],
            [
                'id'    => 30,
                'title' => 'product_status_show',
            ],
            [
                'id'    => 31,
                'title' => 'product_status_delete',
            ],
            [
                'id'    => 32,
                'title' => 'product_status_access',
            ],
            [
                'id'    => 33,
                'title' => 'restaurant_management_access',
            ],
            [
                'id'    => 34,
                'title' => 'setting_access',
            ],
            [
                'id'    => 35,
                'title' => 'province_create',
            ],
            [
                'id'    => 36,
                'title' => 'province_edit',
            ],
            [
                'id'    => 37,
                'title' => 'province_show',
            ],
            [
                'id'    => 38,
                'title' => 'province_delete',
            ],
            [
                'id'    => 39,
                'title' => 'province_access',
            ],
            [
                'id'    => 40,
                'title' => 'district_create',
            ],
            [
                'id'    => 41,
                'title' => 'district_edit',
            ],
            [
                'id'    => 42,
                'title' => 'district_show',
            ],
            [
                'id'    => 43,
                'title' => 'district_delete',
            ],
            [
                'id'    => 44,
                'title' => 'district_access',
            ],
            [
                'id'    => 45,
                'title' => 'restaurant_status_create',
            ],
            [
                'id'    => 46,
                'title' => 'restaurant_status_edit',
            ],
            [
                'id'    => 47,
                'title' => 'restaurant_status_show',
            ],
            [
                'id'    => 48,
                'title' => 'restaurant_status_delete',
            ],
            [
                'id'    => 49,
                'title' => 'restaurant_status_access',
            ],
            [
                'id'    => 50,
                'title' => 'restaurant_create',
            ],
            [
                'id'    => 51,
                'title' => 'restaurant_edit',
            ],
            [
                'id'    => 52,
                'title' => 'restaurant_show',
            ],
            [
                'id'    => 53,
                'title' => 'restaurant_delete',
            ],
            [
                'id'    => 54,
                'title' => 'restaurant_access',
            ],
            [
                'id'    => 55,
                'title' => 'customer_management_access',
            ],
            [
                'id'    => 56,
                'title' => 'customer_create',
            ],
            [
                'id'    => 57,
                'title' => 'customer_edit',
            ],
            [
                'id'    => 58,
                'title' => 'customer_show',
            ],
            [
                'id'    => 59,
                'title' => 'customer_delete',
            ],
            [
                'id'    => 60,
                'title' => 'customer_access',
            ],
            [
                'id'    => 61,
                'title' => 'membership_create',
            ],
            [
                'id'    => 62,
                'title' => 'membership_edit',
            ],
            [
                'id'    => 63,
                'title' => 'membership_show',
            ],
            [
                'id'    => 64,
                'title' => 'membership_delete',
            ],
            [
                'id'    => 65,
                'title' => 'membership_access',
            ],
            [
                'id'    => 66,
                'title' => 'coupon_management_access',
            ],
            [
                'id'    => 67,
                'title' => 'coupon_create',
            ],
            [
                'id'    => 68,
                'title' => 'coupon_edit',
            ],
            [
                'id'    => 69,
                'title' => 'coupon_show',
            ],
            [
                'id'    => 70,
                'title' => 'coupon_delete',
            ],
            [
                'id'    => 71,
                'title' => 'coupon_access',
            ],
            [
                'id'    => 72,
                'title' => 'coupon_type_create',
            ],
            [
                'id'    => 73,
                'title' => 'coupon_type_edit',
            ],
            [
                'id'    => 74,
                'title' => 'coupon_type_show',
            ],
            [
                'id'    => 75,
                'title' => 'coupon_type_delete',
            ],
            [
                'id'    => 76,
                'title' => 'coupon_type_access',
            ],
            [
                'id'    => 77,
                'title' => 'discount_type_create',
            ],
            [
                'id'    => 78,
                'title' => 'discount_type_edit',
            ],
            [
                'id'    => 79,
                'title' => 'discount_type_show',
            ],
            [
                'id'    => 80,
                'title' => 'discount_type_delete',
            ],
            [
                'id'    => 81,
                'title' => 'discount_type_access',
            ],
            [
                'id'    => 82,
                'title' => 'coupon_status_create',
            ],
            [
                'id'    => 83,
                'title' => 'coupon_status_edit',
            ],
            [
                'id'    => 84,
                'title' => 'coupon_status_show',
            ],
            [
                'id'    => 85,
                'title' => 'coupon_status_delete',
            ],
            [
                'id'    => 86,
                'title' => 'coupon_status_access',
            ],
            [
                'id'    => 87,
                'title' => 'point_create',
            ],
            [
                'id'    => 88,
                'title' => 'point_edit',
            ],
            [
                'id'    => 89,
                'title' => 'point_show',
            ],
            [
                'id'    => 90,
                'title' => 'point_delete',
            ],
            [
                'id'    => 91,
                'title' => 'point_access',
            ],
            [
                'id'    => 92,
                'title' => 'reservation_management_access',
            ],
            [
                'id'    => 93,
                'title' => 'cart_management_access',
            ],
            [
                'id'    => 94,
                'title' => 'cart_create',
            ],
            [
                'id'    => 95,
                'title' => 'cart_edit',
            ],
            [
                'id'    => 96,
                'title' => 'cart_show',
            ],
            [
                'id'    => 97,
                'title' => 'cart_delete',
            ],
            [
                'id'    => 98,
                'title' => 'cart_access',
            ],
            [
                'id'    => 99,
                'title' => 'cart_detail_create',
            ],
            [
                'id'    => 100,
                'title' => 'cart_detail_edit',
            ],
            [
                'id'    => 101,
                'title' => 'cart_detail_show',
            ],
            [
                'id'    => 102,
                'title' => 'cart_detail_delete',
            ],
            [
                'id'    => 103,
                'title' => 'cart_detail_access',
            ],
            [
                'id'    => 104,
                'title' => 'address_create',
            ],
            [
                'id'    => 105,
                'title' => 'address_edit',
            ],
            [
                'id'    => 106,
                'title' => 'address_show',
            ],
            [
                'id'    => 107,
                'title' => 'address_delete',
            ],
            [
                'id'    => 108,
                'title' => 'address_access',
            ],
            [
                'id'    => 109,
                'title' => 'reservation_status_create',
            ],
            [
                'id'    => 110,
                'title' => 'reservation_status_edit',
            ],
            [
                'id'    => 111,
                'title' => 'reservation_status_show',
            ],
            [
                'id'    => 112,
                'title' => 'reservation_status_delete',
            ],
            [
                'id'    => 113,
                'title' => 'reservation_status_access',
            ],
            [
                'id'    => 114,
                'title' => 'order_management_access',
            ],
            [
                'id'    => 115,
                'title' => 'order_create',
            ],
            [
                'id'    => 116,
                'title' => 'order_edit',
            ],
            [
                'id'    => 117,
                'title' => 'order_show',
            ],
            [
                'id'    => 118,
                'title' => 'order_delete',
            ],
            [
                'id'    => 119,
                'title' => 'order_access',
            ],
            [
                'id'    => 120,
                'title' => 'order_status_create',
            ],
            [
                'id'    => 121,
                'title' => 'order_status_edit',
            ],
            [
                'id'    => 122,
                'title' => 'order_status_show',
            ],
            [
                'id'    => 123,
                'title' => 'order_status_delete',
            ],
            [
                'id'    => 124,
                'title' => 'order_status_access',
            ],
            [
                'id'    => 125,
                'title' => 'order_detail_create',
            ],
            [
                'id'    => 126,
                'title' => 'order_detail_edit',
            ],
            [
                'id'    => 127,
                'title' => 'order_detail_show',
            ],
            [
                'id'    => 128,
                'title' => 'order_detail_delete',
            ],
            [
                'id'    => 129,
                'title' => 'order_detail_access',
            ],
            [
                'id'    => 130,
                'title' => 'reservation_create',
            ],
            [
                'id'    => 131,
                'title' => 'reservation_edit',
            ],
            [
                'id'    => 132,
                'title' => 'reservation_show',
            ],
            [
                'id'    => 133,
                'title' => 'reservation_delete',
            ],
            [
                'id'    => 134,
                'title' => 'reservation_access',
            ],
            [
                'id'    => 135,
                'title' => 'coupon_customer_status_create',
            ],
            [
                'id'    => 136,
                'title' => 'coupon_customer_status_edit',
            ],
            [
                'id'    => 137,
                'title' => 'coupon_customer_status_show',
            ],
            [
                'id'    => 138,
                'title' => 'coupon_customer_status_delete',
            ],
            [
                'id'    => 139,
                'title' => 'coupon_customer_status_access',
            ],
            [
                'id'    => 140,
                'title' => 'coupon_customer_create',
            ],
            [
                'id'    => 141,
                'title' => 'coupon_customer_edit',
            ],
            [
                'id'    => 142,
                'title' => 'coupon_customer_show',
            ],
            [
                'id'    => 143,
                'title' => 'coupon_customer_delete',
            ],
            [
                'id'    => 144,
                'title' => 'coupon_customer_access',
            ],
            [
                'id'    => 145,
                'title' => 'restaurant_shipping_fee_create',
            ],
            [
                'id'    => 146,
                'title' => 'restaurant_shipping_fee_edit',
            ],
            [
                'id'    => 147,
                'title' => 'restaurant_shipping_fee_show',
            ],
            [
                'id'    => 148,
                'title' => 'restaurant_shipping_fee_delete',
            ],
            [
                'id'    => 149,
                'title' => 'restaurant_shipping_fee_access',
            ],
            [
                'id'    => 150,
                'title' => 'operating_time_create',
            ],
            [
                'id'    => 151,
                'title' => 'operating_time_edit',
            ],
            [
                'id'    => 152,
                'title' => 'operating_time_show',
            ],
            [
                'id'    => 153,
                'title' => 'operating_time_delete',
            ],
            [
                'id'    => 154,
                'title' => 'operating_time_access',
            ],
            [
                'id'    => 155,
                'title' => 'banner_create',
            ],
            [
                'id'    => 156,
                'title' => 'banner_edit',
            ],
            [
                'id'    => 157,
                'title' => 'banner_show',
            ],
            [
                'id'    => 158,
                'title' => 'banner_delete',
            ],
            [
                'id'    => 159,
                'title' => 'banner_access',
            ],
            [
                'id'    => 160,
                'title' => 'rating_create',
            ],
            [
                'id'    => 161,
                'title' => 'rating_edit',
            ],
            [
                'id'    => 162,
                'title' => 'rating_show',
            ],
            [
                'id'    => 163,
                'title' => 'rating_delete',
            ],
            [
                'id'    => 164,
                'title' => 'rating_access',
            ],
            [
                'id'    => 165,
                'title' => 'notification_create',
            ],
            [
                'id'    => 166,
                'title' => 'notification_edit',
            ],
            [
                'id'    => 167,
                'title' => 'notification_show',
            ],
            [
                'id'    => 168,
                'title' => 'notification_delete',
            ],
            [
                'id'    => 169,
                'title' => 'notification_access',
            ],
            [
                'id'    => 170,
                'title' => 'profile_password_edit',
            ],

            [
                'id'    => 170,
                'title' => 'car_booking_create',
            ],
            [
                'id'    => 171,
                'title' => 'car_booking_edit',
            ],
            [
                'id'    => 172,
                'title' => 'car_booking_show',
            ],
            [
                'id'    => 173,
                'title' => 'car_booking_delete',
            ],
            [
                'id'    => 174,
                'title' => 'car_booking_access',
            ],
            [
                'id'    => 175,
                'title' => 'car_booking_management_access',
            ],
            [
                'id'    => 176,
                'title' => 'car_booking_status_create',
            ],
            [
                'id'    => 177,
                'title' => 'car_booking_status_edit',
            ],
            [
                'id'    => 178,
                'title' => 'car_booking_status_show',
            ],
            [
                'id'    => 179,
                'title' => 'car_booking_status_delete',
            ],
            [
                'id'    => 180,
                'title' => 'car_booking_status_access',
            ],

            [
                'id'    => 181,
                'title' => 'hash_tag_create',
            ],
            [
                'id'    => 182,
                'title' => 'hash_tag_edit',
            ],
            [
                'id'    => 183,
                'title' => 'hash_tag_show',
            ],
            [
                'id'    => 184,
                'title' => 'hash_tag_delete',
            ],
            [
                'id'    => 185,
                'title' => 'hash_tag_access',
            ],
            [
                'id'    => 186,
                'title' => 'product_unit_create',
            ],
            [
                'id'    => 187,
                'title' => 'product_unit_edit',
            ],
            [
                'id'    => 188,
                'title' => 'product_unit_show',
            ],
            [
                'id'    => 189,
                'title' => 'product_unit_delete',
            ],
            [
                'id'    => 190,
                'title' => 'product_unit_access',
            ],
            [
                'id'    => 192,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
