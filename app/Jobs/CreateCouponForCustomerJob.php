<?php

namespace App\Jobs;

use App\Constants\Notification as NotificationConst;
use App\Helpers\LoggingHelper;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use App\Models\Customer;
use App\Models\Device;
use App\Notifications\OneSignalNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateCouponForCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $coupon;

    /**
     * Create a new job instance.
     *
     * @param Coupon $coupon
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!empty($this->coupon)) {
            $customers = null;
            switch ($this->coupon->coupon_type_id) {
                case 1:
                    $customers = Customer::get();
                    break;
                case 2:
                    // Customer vừa đăng ký tạo ở sign up
                    break;
                case 3:
                    $month = Carbon::now()->month;
                    $customers = Customer::whereMonth('birthday', '=', $month)->get();
                    break;
                case 4:
                    $customers = Customer::where('membership_id', '=', null)->get();
                    break;
                case 5:
                    // membership đồng
                    $customers = Customer::where('membership_id', '=', 1)->get();
                    break;
                case 6:
                    // membership bạc
                    $customers = Customer::where('membership_id', '=', 2)->get();
                    break;
                case 7:
                    // membership vàng
                    $customers = Customer::where('membership_id', '=', 3)->get();
                    break;
                case 8:
                    // membership kim cương
                    $customers = Customer::where('membership_id', '=', 4)->get();
                    break;
            }
            if (!empty($customers)) {
                foreach ($customers as $customer) {
                    $couponCustomerId = CouponCustomer::create([
                        'coupon_id'   => $this->coupon->id,
                        'customer_id' => $customer->id,
                        'status_id'   => 2,
                        'code'        => 'temp',
                    ])->id;
                    if (!empty($couponCustomerId)) {
                        $code = $this->coupon->code . '_' . $couponCustomerId;
                        CouponCustomer::where('id', $couponCustomerId)->update(['code' => $code]);
                    }

                    #Notification donate coupon
                    try {
                        $device_token = Device::where("customer_id", $customer->id)->pluck("device_token")->toArray();
                        $name = $customer->first_name ?? null;
                        $title = "🍩 Tặng bạn {$name} mã giảm giá nè.";
                        $sub_title = "Nhấp vào để xem chi tiết nhé 👉👉👉";
                        $content_body = $this->coupon->description ?? null;
                        $target_type = NotificationConst::TARGET_TYPE['DONATE_COUPON']; //
                        $target_id = $this->coupon->id; //

                        (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token);
                    } catch (\Exception $exception) {
                        LoggingHelper::logException($exception);
                    }
                }
            }
        }

    }
}
