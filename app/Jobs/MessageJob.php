<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\Message;
use App\Notifications\OneSignalNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Constants\Message as MessageConst;

class MessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messages;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messages)
    {
        $this->messages = $messages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->messages as $message) {
            //All customer
            if (empty($message->customer_id)) {
                //App
                if ($message->app_notification) {
                    $device_tokens = Device::whereIn("platform", [Device::PLATFORM['Android'], Device::PLATFORM['IOS']])->get()->pluck("device_token")->toArray();
                    $device_tokens = array_chunk($device_tokens, 1000);

                    $customerIDs = Device::whereIn("platform", [Device::PLATFORM['Android'], Device::PLATFORM['IOS']])->get()->pluck("customer_id")->toArray();
                    $customerIDs = array_unique($customerIDs);

                    foreach ($device_tokens as $device_token) {
                        (new OneSignalNotification())->toOneSignal(
                            $message->title,
                            $message->sub_title,
                            $message->content,
                            $message->target_type,
                            $message->target_id,
                            $device_token
                        );
                    }
                    //Update status message
                    Message::find($message->id)->update([
                        "status"              => MessageConst::STATUS['SENT'],
                        "app_notification_at" => Carbon::now()->toDateTimeString(),
                    ]);
                    //Create message for customer
                    foreach ($customerIDs as $customer_id) {
                        Message::create([
                            "title"               => $message->title,
                            "sub_title"           => $message->sub_title,
                            "content"             => $message->content,
                            "target_type"         => $message->target_type,
                            "target_id"           => $message->target_id,
                            "app_notification"    => $message->app_notification,
                            "app_notification_at" => Carbon::now()->toDateTimeString(),
                            "customer_id"         => $customer_id,
                            "status"              => MessageConst::STATUS['SENT'],
                        ]);
                    }
                }
            } else {
                //App
                if ($message->app_notification) {
                    $customer_id = $message->customer_id;
                    $device_token = Device::whereIn("platform", [Device::PLATFORM['Android'], Device::PLATFORM['IOS']])->where("customer_id", $customer_id)->pluck("device_token")->toArray();

                    (new OneSignalNotification())->toOneSignal(
                        $message->title,
                        $message->sub_title,
                        $message->content_body,
                        $message->target_type,
                        $message->target_id,
                        $device_token
                    );

                    //Update status message
                    Message::find($message->id)->update([
                        "status"              => MessageConst::STATUS['SENT'],
                        "app_notification_at" => Carbon::now()->toDateTimeString(),
                    ]);
                }
            } //Per user
        }
    }
}
