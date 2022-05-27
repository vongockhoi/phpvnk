<?php

namespace App\Jobs\Reservation;

use App\Constants\Globals\Role as RoleConstant;
use App\Constants\Notification as NotificationConst;
use App\Constants\Reservation as ReservationConstant;
use App\Constants\Notification as NotificationConstant;
use App\Helpers\CommonHelper;
use App\Models\Device;
use App\Notifications\OneSignalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateReservationJobForApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $device_token = CommonHelper::findDeviceToken($this->reservation->restaurant_id);

        if ($device_token) {
            $title = "New reservation #{$this->reservation->id}";
            $sub_title = "Bạn vừa có 1 đơn đặt bàn mới #{$this->reservation->id}";
            $content_body = null;
            $target_type = NotificationConst::TARGET_TYPE['RESERVATION'];
            $target_id = $this->reservation->id;
            (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token, null, NotificationConst::APP_ID['NORI_STAFF']);
        }
    }
}
