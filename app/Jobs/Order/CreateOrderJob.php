<?php

namespace App\Jobs\Order;

use App\Constants\Device as DeviceConst;
use App\Constants\Notification as NotificationConst;
use App\Models\Device;
use App\Models\OrderStatus;
use App\Notifications\OneSignalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer_id = $this->order->customer_id;
        $device_token = Device::where("customer_id", $customer_id)->pluck("device_token")->toArray();

        //
        $title = "🌟🌟Thành công🌟🌟";
        $sub_title = "Đơn hàng của bạn đã được tạo thành công👉👉👉";
        $content_body = null;
        $target_type = NotificationConst::TARGET_TYPE['STATUS_ORDER']; //
        $target_id = $this->order->id; //

        (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token);
    }
}
