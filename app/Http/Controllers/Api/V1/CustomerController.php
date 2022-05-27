<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\CouponCustomer as CouponCustomerConst;
use App\Constants\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CarBooking\StoreCarBookingRequest;
use App\Http\Resources\Admin\CarBookingResource;
use App\Http\Resources\Admin\CustomerResource;
use App\Http\Resources\Admin\DeviceResource;
use App\Models\CarBooking;
use App\Models\CouponCustomer;
use App\Models\Device;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function init()
    {
        $customer_id = Auth::id();
        $count_my_coupon = CouponCustomer::where("customer_id", $customer_id)
            ->where("status_id", CouponCustomerConst::STATUS['NOT_USED'])
            ->count();

        $count_notification_unread = DB::table('messages')
            ->whereNull('last_read_at')
            ->where("customer_id", $customer_id)
            ->count();

        $form = new \stdClass();
        $form->count_my_coupon = $count_my_coupon;
        $form->count_notification_unread = $count_notification_unread;
        return new CustomerResource((array) $form);
    }
}
