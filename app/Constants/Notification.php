<?php

namespace App\Constants;

class Notification
{
    const STATUS = array(
        'UNSENT' => 0,
        'SENT'   => 1,
    );
    const TARGET_USER = array(
        'ALL'     => 0,
        'ANDROID' => 1,
        'IOS'     => 2,
    );
    const TARGET_TYPE = [
        'DONATE_COUPON' => 1,
        'NORMAL'        => 2,
        'STATUS_ORDER'  => 3,
        'UP_MEMBER'     => 4,
        'RATING'        => 5,
        'ORDER'         => 6, #app nhan vien
        'RESERVATION'   => 7, #app nhan vien
    ];
    const NOTIFICATION_TYPE = [
        'ORDER'       => 1,
        'RESERVATION' => 2,
    ];
    const APP_ID = array(
        'NORI_FOOD'  => 1,
        'NORI_STAFF' => 2,
    );
}
