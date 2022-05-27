<?php

namespace App\Console\Commands;

use App\Constants\Notification as NotificationConst;
use App\Helpers\LoggingHelper;
use App\Jobs\ChangeStatusOrderJob;
use App\Jobs\OTPSender;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Membership;
use App\Models\Order;
use App\Models\Point;
use App\Models\PointHistory;
use App\Models\Message;
use App\Notifications\ChangeStatusOrderNotification;
use App\Notifications\OneSignalNotification;
use App\Notifications\SlackNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Constants\Message as MessageConst;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        OTPSender::dispatch( 0353116200, 2525);


//        $slackWebhookUrl = config('slack.webhook_url');
//        Notification::route('slack', $slackWebhookUrl)
//            ->notify(new SlackNotification());

//        $title = "Android: Lẩu Lòng Bò Nhật Bản 😅";
//        $sub_title = "Kiểu Nhật, Đồ nướng, Kiểu Á, Quán rượu, Tốt cho sức khỏe, Thức ăn đường phố";
//        $content_body = "Nội dung";
//        $target_type = 1;
//        $target_id = 322;
//        $device_token = [
//            '60300e2a-5e40-11ec-b2c9-d2c7694a66a4',
//        ];

//        (new OneSignalNotification())->toOneSignal($title, $sub_title, $content_body, $target_type, $target_id, $device_token);

//        $order = Order::find(28);
//        DB::beginTransaction();
//        try {
//            #start
//            $pointHistories = PointHistory::where("customer_id", $order->customer_id)->where("order_id", $order->id)->first();
//            if (empty($pointHistories)) {
//                $point = Point::where("customer_id", $order->customer_id)->first();
//                $total_price = $order->total_price;
//                if (empty($point)) {
//                    $num_of_point = $total_price / 100000;
//                    $num_of_point = floor($num_of_point);
//                    Point::create([
//                        'num_of_point' => $num_of_point,
//                        'total_price' => $total_price,
//                        'customer_id' => $order->customer_id,
//                    ]);
//                } else {
//                    $total_price += $point->total_price;
//                    $num_of_point = $total_price / 100000;
//                    $num_of_point = floor($num_of_point);
//                    $point->update([
//                        'num_of_point' => $num_of_point,
//                        'total_price' => $total_price,
//                    ]);
//                }
//
//                PointHistory::create([
//                    'order_id' => $order->id,
//                    'customer_id' => $order->customer_id,
//                    'total_price' => $order->total_price,
//                ]);
//            }
//
//            #update rank member
//            $point = Point::where("customer_id", $order->customer_id)->first();
//            if (!empty($point)) {
//                $number_of_point = $point->num_of_point;
//                $memberships = Membership::orderBy("level_up_points", "desc")->get();
//
//                $membership_id = null;
//                foreach ($memberships as $membership) {
//                    if ($number_of_point >= $membership->level_up_points) {
//                        $membership_id = $membership->id;
//                        break;
//                    }
//                }
//                $customer = Customer::find($order->customer_id);
//                if ($customer->membership_id != $membership_id) {
//                    $customer->update(["membership_id" => $membership_id]);
//
//                    #noti
//                    $first_name = Customer::find($order->customer_id)->first_name ?? null;
//                    $membership = Membership::find($membership_id);
//                    $discount_value = (int)$membership->discount_value ?? null;
//                    $membership_name = $membership->name ?? null;
//                    $title = "Chúc mừng bạn {$first_name} đã thăng hạng";
//                    $sub_title = "Thành viên {$membership_name} được giảm giá {$discount_value}% trên tổng đơn hàng.";
//                    $content_body = "Chúc mừng bạn {$first_name} đã thăng hạng. Thành viên {$membership_name} được giảm giá {$discount_value}% trên tổng đơn hàng.";
//
//                    Message::create([
//                        'title' => $title,
//                        'sub_title' => $sub_title,
//                        'content' => $content_body,
//                        'target_type' => NotificationConst::TARGET_TYPE['UP_MEMBER'],
//                        'target_id' => null,
//                        'app_notification' => 1,
//                        'customer_id' => $order->customer_id,
//                        'status' => MessageConst::STATUS['UNSENT'],
//                    ]);
//                }
//            }
//
//            #end
//            DB::commit();
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            LoggingHelper::logException($exception);
//        }
    }
}
