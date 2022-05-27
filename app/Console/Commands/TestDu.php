<?php

namespace App\Console\Commands;

use App\Constants\Globals\Role as RoleConstant;
use App\Models\Device;
use Illuminate\Console\Command;
use App\Constants\Order as OrderConst;
use App\Constants\Notification as NotificationConstant;

class TestDu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_du';

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

        $firebaseToken = Device::whereHas('user', function($q) {
            $q->whereHas('roles', function($e) {
                $e->where('roles.id', RoleConstant::ROLE['RESTAURANT_MANAGER']);
            });
            $q->whereHas('restaurants', function($e) {
                $e->where('restaurants.id', 1);
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
                "title" => "New order #212",
                "body"  => "Bạn vừa có 1 đơn hàng mới #212",
            ],
            "data"             => [
                "orderUrl"         => "https://admin.norifood.vn/admin/orders/212/edit",
                "status"           => OrderConst::STATUS['WAIT_CONFIRM'],
                "notificationType" => NotificationConstant::NOTIFICATION_TYPE['ORDER'],
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
    }
}
