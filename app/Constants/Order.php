<?php

namespace App\Constants;

class Order
{
    const PAYMENT_METHOD = array(
        'ON_DELIVERY' => 0,
        'MOMO'        => 1,
    );
    const PROVIDER = array(
        'MOMO' => 1,
    );
    const TYPE_ACTION = array(
        'REPLACE' => 0,
        'ADD'     => 1,
        'REMOVE'  => 2,
    );
    const STATUS = array(
        'WAIT_CONFIRM' => 1,
        'CONFIRM'      => 2,
        'GOING'        => 3,
        'DELIVERING'   => 4,
        'COMPLETED'    => 5,
        'CANCEL'       => 6,
    );
}
