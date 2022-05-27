<?php

namespace App\Console\Commands\Coupon;

use App\Constants\Coupon as CouponConst;
use App\Constants\CouponCustomer as CouponCustomerConst;
use App\Constants\Notification as NotificationConst;
use App\Helpers\LoggingHelper;
use App\Jobs\CreateCouponForCustomerJob;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use App\Models\Customer;
use App\Models\Device;
use App\Notifications\OneSignalNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IssueCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'IssueCoupon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customers = DB::table("customers")->get();
        $couponAll = DB::table('coupons')
            ->where('status_id', CouponConst::STATUS['ACTIVE'])
            ->where(function($query) {
                $query->orWhere('coupon_type_id', CouponConst::TYPE['ALL_CUSTOMER']);
                $query->orWhere('coupon_type_id', CouponConst::TYPE['CUSTOMER_JUST_REGISTERED']);
            })
            ->get();
        foreach ($customers as $customer) {
            $customerId = $customer->id;
            foreach ($couponAll as $coupon) {
                $coupon_customer = DB::table("coupon_customers")
                    ->where('customer_id', $customerId)
                    ->where('coupon_id', $coupon->id)
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
                            $content_body = $coupon->description ?? null;;
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
}
