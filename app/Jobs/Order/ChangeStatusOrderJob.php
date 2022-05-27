<?php

namespace App\Jobs\Order;

use App\Constants\Device as DeviceConst;
use App\Constants\Notification as NotificationConst;
use App\Constants\Order as OrderConst;
use App\Models\Device;
use App\Models\OrderStatus;
use App\Models\Rating;
use App\Notifications\OneSignalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChangeStatusOrderJob implements ShouldQueue
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
        #noti khi thay doi trang thai don hang
        $customer_id = $this->order->customer_id;
        $device_token = Device::where("customer_id", $customer_id)->pluck("device_token")->toArray();

        //
        $order_status = OrderStatus::find($this->order->status_id)->name;

        //
        $title = "🍰🍰Thông báo trạng thái đơn hàng 🍰🍰";
        $sub_title = "[{$order_status}]. Nhấp xem chi tiết 👉👉👉";
        $content_body = null;
        $target_type = NotificationConst::TARGET_TYPE['STATUS_ORDER']; //
        $target_id = $this->order->id; //

        (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token);

        #noti người dùng đánh giá đơn hàng
        if ($this->order->status_id == OrderConst::STATUS['COMPLETED']) {
            $rating = Rating::where("order_id", $this->order->id)->first();
            if (empty($rating)) {
                $title = "Đơn hàng đã hoàn thành rồi.";
                $sub_title = "Mời bạn đánh giá mức độ hài lòng về đơn hàng nhé! 👉";
                $content_body = null;
                $target_type = NotificationConst::TARGET_TYPE['RATING']; //
                $target_id = $this->order->id; //
                $additional = array(
                    'code' => $this->order->code,
                );
                (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token, $additional);
            }
        }
    }
}
