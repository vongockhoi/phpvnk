<?php

namespace App\Constants;

class Coupon
{
    const STATUS = array(
        'ACTIVE'  => 1,
        'STOP'    => 2,
        'EXPIRED' => 3,
    );
    const TYPE = array(
        'ALL_CUSTOMER'               => 1,
        'CUSTOMER_JUST_REGISTERED'   => 2,
        'BIRTHDAY_CUSTOMER_IN_MONTH' => 3,
        'CUSTOMER_MEMBER'            => 4,
        'CUSTOMER_MEMBER_BRONZE'     => 5,
        'CUSTOMER_MEMBER_SILVER'     => 6,
        'CUSTOMER_MEMBER_GOLD'       => 7,
        'CUSTOMER_MEMBER_DIAMOND'    => 8,
    );
}
