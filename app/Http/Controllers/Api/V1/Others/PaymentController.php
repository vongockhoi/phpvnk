<?php

namespace App\Http\Controllers\Api\V1\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function listenCallback(Request $request)
    {
        return $request->all();
    }
}
