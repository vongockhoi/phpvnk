<?php

namespace App\Console\Commands;

use App\Constants\Notification as NotificationConts;
use App\Constants\Message as MessageConts;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MinuteSendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-notification';

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
        $notifications = Notification::where("status", NotificationConts::STATUS['UNSENT'])
            ->where('schedule_time', '>=', date('Y-m-d H:i:00'))
            ->where('schedule_time', '<=', date('Y-m-d H:i:59'))
            ->get();

        if (!empty($notifications)) {
            foreach ($notifications as $notification) {
                Message::create([
                    'title'            => $notification->title,
                    'sub_title'        => $notification->sub_title,
                    'content'          => $notification->content,
                    'target_type'      => $notification->target_type,
                    'target_id'        => $notification->target_id,
                    'app_notification' => 1,
                    'status'           => MessageConts::STATUS['UNSENT'],
                ]);

                $notification->update(['status' => NotificationConts::STATUS['SENT']]);
            }
        }
    }
}
