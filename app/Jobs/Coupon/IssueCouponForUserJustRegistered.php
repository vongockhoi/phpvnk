<?php

namespace App\Jobs\Coupon;

use App\Constants\CouponCustomer as CouponCustomerConst;
use App\Constants\Notification as NotificationConst;
use App\Helpers\LoggingHelper;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use App\Models\Customer;
use App\Models\Device;
use App\Models\User;
use App\Notifications\OneSignalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Constants\Coupon as CouponConst;

class IssueCouponForUserJustRegistered implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customerId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customerId = $this->customerId;

        $couponAll = DB::table('coupons')
            ->where('status_id', CouponConst::STATUS['ACTIVE'])
            ->where(function($query) {
                $query->orWhere('coupon_type_id', CouponConst::TYPE['ALL_CUSTOMER']);
                $query->orWhere('coupon_type_id', CouponConst::TYPE['CUSTOMER_JUST_REGISTERED']);
            })
            ->get();

        foreach ($couponAll as $coupon) {
            $coupon_customer = DB::table("coupon_customers")
                ->where("coupon_id", $coupon->id)
                ->where("customer_id", $customerId)
                ->first();
            if (empty($coupon_customer)) {
                $couponCustomerId = CouponCustomer::create([
                    'coupon_id'   => $coupon->id,
                    'customer_id' => $customerId,
                    'status_id'   => CouponCustomerConst::STATUS['NOT_USED'],
                    'code'        => 'temp',
                ])->id;
                if (!empty($couponCustomerId)) {
                    $code = $coupon->code . '_' . $couponCustomerId;
                    CouponCustomer::where('id', $couponCustomerId)->update(['code' => $code]);
                }

                #Notification donate coupon
                try {
                    $customer = Customer::find($customerId);
                    $device_token = Device::where("customer_id", $customer->id)->pluck("device_token")->toArray();
                    if ($device_token) {
                        $name = $customer->first_name ?? null;
                        $title = "🍩 Tặng bạn {$name} mã giảm giá nè.";
                        $sub_title = "Nhấp vào để xem chi tiết nhé 👉👉👉";
                        $content_body = $coupon->description ?? null;
                        $target_type = NotificationConst::TARGET_TYPE['DONATE_COUPON']; //
                        $target_id = $coupon->id; //

                        (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token);
                    }
                } catch (\Exception $exception) {
                    LoggingHelper::logException($exception);
                }
            }
        }
    }
}
