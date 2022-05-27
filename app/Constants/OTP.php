<?php

namespace App\Constants;

class OTP
{
    const TIME_OUT_SEND_OTP = 10; //second 180s in production

    const TYPE = array(
        'VERIFY_ACCOUNT' => 1
    );

    const TYPE_SEND = array(
        'SIGN_UP' => 2,
        'SIGN_IN' => 1
    );

    const STATUS = array(
        'NOT_USED_YET' => 0,
        'USED' => 1
    );
}
