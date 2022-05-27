<?php

namespace App\Constants;

class Reservation
{
    const STATUS = array(
        'WAIT_CONFIRM' => 1,
        'CONFIRM'      => 2,
        'CANCEL'       => 3,
    );
}
