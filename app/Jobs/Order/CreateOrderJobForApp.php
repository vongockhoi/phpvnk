<?php

namespace App\Jobs\Order;

use App\Constants\Device as DeviceConst;
use App\Constants\Globals\Role as RoleConstant;
use App\Constants\Notification as NotificationConst;
use App\Helpers\CommonHelper;
use App\Models\Device;
use App\Models\OrderStatus;
use App\Notifications\OneSignalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateOrderJobForApp implements ShouldQueue
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
        $device_token = CommonHelper::findDeviceToken($this->order->restaurant_id);

        if ($device_token) {
            $title = "New order #{$this->order->id}";
            $sub_title = "Bạn vừa có 1 đơn hàng mới #{$this->order->id}";
            $content_body = null;
            $target_type = NotificationConst::TARGET_TYPE['ORDER'];
            $target_id = $this->order->id;
            (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token, null, NotificationConst::APP_ID['NORI_STAFF']);
        }
    }
}
