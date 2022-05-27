<?php

return [
    'partnerCode'            => env('MOMO_PAY_PARTNER_CODE'),
    'iosSchemeId'            => env('MOMO_PAY_IOS_SCHEME_ID'),
    'publicKey'              => env('MOMO_PAY_PUBLIC_KEY'),
    'apiEndpoint'            => env('MOMO_PAY_API_ENDPOINT'),
    'queryStatusApiEndPoint' => env('MOMO_PAY_QUERY_STATUS_API_ENDPOINT'),
    'refundApiEndPoint'      => env('MOMO_PAY_REFUND_API_ENDPOINT'),
    'notifyUrl'              => env('MOMO_PAY_NOTIFY_URL'),
    'returnUrl'              => env('MOMO_PAY_RETURN_URL'),
];
