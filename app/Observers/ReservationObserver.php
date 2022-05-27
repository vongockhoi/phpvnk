<?php

namespace App\Observers;

use App\Constants\Globals\Role as RoleConstant;
use App\Constants\Notification as NotificationConstant;
use App\Constants\Reservation as ReservationConstant;
use App\Jobs\Reservation\CancelReservationJobForApp;
use App\Jobs\Reservation\CreateReservationJobForApp;
use App\Jobs\Reservation\CreateReservationJobForWeb;
use App\Models\Device;
use App\Models\Reservation;

class ReservationObserver
{
    public function created(Reservation $reservation)
    {
        CreateReservationJobForWeb::dispatch($reservation);
        CreateReservationJobForApp::dispatch($reservation);
    }

    public function updated(Reservation $reservation)
    {
        if ($reservation->isDirty('status_id')) {
            if ($reservation->status_id == ReservationConstant::STATUS['CANCEL']) {
                $firebaseToken = Device::whereHas('user', function($q) use ($reservation) {
                    $q->whereHas('roles', function($e) {
                        $e->where('roles.id', RoleConstant::ROLE['RESTAURANT_MANAGER']);
                    });
                    $q->whereHas('restaurants', function($e) use ($reservation) {
                        $e->where('restaurants.id', $reservation->restaurant_id);
                    });
                })->orWhereHas('user', function($q) {
                    $q->whereHas('roles', function($e) {
                        $e->whereIn('roles.id', [RoleConstant::ROLE['ADMIN_TECH'], RoleConstant::ROLE['SUPER_MANAGER']]);
                    });
                })->whereNotNull('device_token')->where('platform', '=', Device::PLATFORM['Web'])->pluck('device_token')->all();

                $url = 'https://fcm.googleapis.com/fcm/send';

                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification"     => [
                        "title" => "New reservation #{$reservation->id}",
                        "body"  => "Bạn vừa có 1 đơn đặt bàn mới #{$reservation->id}",
                    ],
                    "data"             => [
                        "orderUrl"         => "https://admin.norifood.vn/admin/reservations/{$reservation->id}/edit",
                        "status"           => ReservationConstant::STATUS['CANCEL'],
                        "notificationType" => NotificationConstant::NOTIFICATION_TYPE['RESERVATION'],
                    ],
                ];

                $encodedData = json_encode($data);

                $headers = [
                    'Authorization:key=AAAAbKGVTuI:APA91bEL9W3XnlUjW6pAx8pFJK5x45QjBkqDbMo95b2eAoNU_HIVyOLc4lI6gnmlaJ8vc5KDGoI9pVly7EWcCYByj1BCCt02DYYEd9mKLe_L5y-UbLlEEArG4ZBlPd3Sw4rXYNbxikyk',
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

                // Execute post
                $result = curl_exec($ch);

                if ($result === false) {
                    die('Curl failed: ' . curl_error($ch));
                }

                // Close connection
                curl_close($ch);

                #
                CancelReservationJobForApp::dispatch($reservation);
            }
        }
    }
}
