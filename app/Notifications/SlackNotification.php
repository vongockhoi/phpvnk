<?php

namespace App\Notifications;

use App\Constants\Globals\Exception as ExceptionConst;
use App\Constants\Globals\Slack;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Log;

class SlackNotification extends Notification
{
    use Queueable;

    public $event;

    public function __construct(Exception $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack()
    {
        $issueTime = Carbon::now()->toDateTimeString();
        $env = app()->environment();
        $message = $this->event->getMessage();
        $file = $this->event->getFile();
        $line = $this->event->getLine();
        $content = "*Có biến rồi các đại ka ơi!!!*\n*Env:* $env\n*Message:* $message\n*File:* $file\n*Line:* $line\n*Issue time:* $issueTime";

        return (new SlackMessage())
            ->from('Joybot', ':ghost:')
            ->to(Slack::CHANNEL['NORI_FOOD'])
            ->content($content);
    }
}
