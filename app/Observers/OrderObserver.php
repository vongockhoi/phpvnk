<?php

namespace App\Observers;

use App\Constants\Globals\Role as RoleConstant;
use App\Constants\Message as MessageConst;
use App\Constants\Notification as NotificationConst;
use App\Constants\Notification as NotificationConstant;
use App\Helpers\LoggingHelper;
use App\Jobs\Order\CancelOrderJobForApp;
use App\Jobs\Order\ChangeStatusOrderJob;
use App\Jobs\Order\CreateOrderJob;
use App\Jobs\Order\CreateOrderJobForApp;
use App\Jobs\Order\CreateOrderJobForWeb;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Membership;
use App\Models\Message;
use App\Models\Order;
use App\Constants\Order as OrderConst;
use App\Models\Point;
use App\Models\PointHistory;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    public function created(Order $order)
    {
        CreateOrderJob::dispatch($order);
        CreateOrderJobForWeb::dispatch($order);
        CreateOrderJobForApp::dispatch($order);
    }

    public function updated(Order $order)
    {
        if ($order->isDirty('status_id')) {
            #noti khi thay doi trang thai don hang
            ChangeStatusOrderJob::dispatch($order);

            #khi hoan thanh trang thai don hang
            if ($order->status_id == OrderConst::STATUS['COMPLETED']) {
                #point
                DB::beginTransaction();
                try {
                    #start
                    $pointHistories = PointHistory::where("customer_id", $order->customer_id)->where("order_id", $order->id)->first();
                    if (empty($pointHistories)) {
                        $point = Point::where("customer_id", $order->customer_id)->first();
                        $total_price = $order->total_price;
                        if (empty($point)) {
                            $num_of_point = $total_price / 100000;
                            $num_of_point = floor($num_of_point);
                            Point::create([
                                'num_of_point' => $num_of_point,
                                'total_price'  => $total_price,
                                'customer_id'  => $order->customer_id,
                            ]);
                        } else {
                            $total_price += $point->total_price;
                            $num_of_point = $total_price / 100000;
                            $num_of_point = floor($num_of_point);
                            $point->update([
                                'num_of_point' => $num_of_point,
                                'total_price'  => $total_price,
                            ]);
                        }

                        PointHistory::create([
                            'order_id'    => $order->id,
                            'customer_id' => $order->customer_id,
                            'total_price' => $order->total_price,
                        ]);
                    }

                    #update rank member
                    $point = Point::where("customer_id", $order->customer_id)->first();
                    if (!empty($point)) {
                        $number_of_point = $point->num_of_point;
                        $memberships = Membership::orderBy("level_up_points", "desc")->get();

                        $membership_id = null;
                        foreach ($memberships as $membership) {
                            if ($number_of_point >= $membership->level_up_points) {
                                $membership_id = $membership->id;
                                break;
                            }
                        }
                        $customer = Customer::find($order->customer_id);
                        if ($customer->membership_id != $membership_id && !empty($membership_id)) {
                            $customer->update(["membership_id" => $membership_id]);

                            #noti
                            $first_name = Customer::find($order->customer_id)->first_name ?? null;
                            $membership = Membership::find($membership_id);
                            $discount_value = (int)$membership->discount_value ?? null;
                            $membership_name = $membership->name ?? null;
                            $title = "Chúc mừng bạn {$first_name} đã thăng hạng";
                            $sub_title = "Thành viên {$membership_name} được giảm giá {$discount_value}% trên tổng đơn hàng.";
                            $content_body = "Chúc mừng bạn {$first_name} đã thăng hạng. Thành viên {$membership_name} được giảm giá {$discount_value}% trên tổng đơn hàng.";

                            Message::create([
                                'title'            => $title,
                                'sub_title'        => $sub_title,
                                'content'          => $content_body,
                                'target_type'      => NotificationConst::TARGET_TYPE['UP_MEMBER'],
                                'target_id'        => null,
                                'app_notification' => 1,
                                'customer_id'      => $order->customer_id,
                                'status'           => MessageConst::STATUS['UNSENT'],
                            ]);
                        }
                    }

                    #end
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    LoggingHelper::logException($exception);
                }
            }

            if ($order->status_id == OrderConst::STATUS['CANCEL']) {
                #noti for app
                CancelOrderJobForApp::dispatch($order);

                #noti for web
                $firebaseToken = Device::whereHas('user', function($q) use ($order) {
                    $q->whereHas('roles', function($e) {
                        $e->where('roles.id', RoleConstant::ROLE['RESTAURANT_MANAGER']);
                    });
                    $q->whereHas('restaurants', function($e) use ($order) {
                        $e->where('restaurants.id', $order->restaurant_id);
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
                        "title" => "Order cancelled #{$order->id}",
                        "body"  => "Một order vừa hủy #{$order->id}",
                    ],
                    "data"             => [
                        "orderUrl"         => "https://admin.norifood.vn/admin/orders/{$order->id}/edit",
                        "status"           => OrderConst::STATUS['CANCEL'],
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
    }
}
