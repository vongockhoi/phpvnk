<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use App\Constants\Notification as NotificationConst;

class OneSignalNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function toOneSignal(
        $title,
        $sub_title,
        $content_body,
        $target_type,
        $target_id,
        $device_token,
        array $additional = null,
        $appId = NotificationConst::APP_ID['NORI_FOOD']
    ) {
        switch ($appId) {
            case NotificationConst::APP_ID['NORI_FOOD']:
                $app_id = config('onesignal.app_id');
                break;
            case NotificationConst::APP_ID['NORI_STAFF']:
                $app_id = config('onesignal.app_nori_staff_id');
                break;
            default:
                $app_id = config('onesignal.app_id');
        }

        $rest_api_key = config('onesignal.rest_api_key');
        $api = config('onesignal.api');
        $content = array("en" => $sub_title);
        $header = array("en" => $title);
        $data = array(
            "title"       => $title,
            "sub_title"   => $sub_title,
            "content"     => $content_body,
            "target_type" => $target_type,
            "target_id"   => $target_id,
        );
        if (!empty($additional)) {
            $data = array_merge($data, $additional);
        }
        $fields = array(
            'app_id'             => $app_id,
            'data'               => $data,
            'contents'           => $content,
            'headings'           => $header,
            'include_player_ids' => $device_token,
        );

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $rest_api_key,
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = (string)$response ? json_decode((string)$response, true) : [];
        $errors = $response['errors'] ?? null;
        if ($errors) {
            Log::error($response['errors']);
        }
    }
}
