<?php

namespace App\Http\Controllers\Admin;

use App\Models\CarBooking;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $user = User::find(auth()->id());

        if ($user->isAdmin) {
            #Line chart
            $table = DB::table("orders")
                ->whereMonth('created_at', '=', Carbon::now()->month)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
                ->orderBy("day")
                ->groupBy("day")
                ->get();
            $order_days = $table->pluck("day")->toArray();
            $order_totals = $table->pluck("total")->toArray();

            #Text datetime
            $monthNow = Carbon::now()->isoFormat('MMMM Y');

            #
            $order_statuses = DB::table("order_statuses")->get(['id', 'name']);
            $table = DB::table("orders")
                ->whereMonth('created_at', '=', Carbon::now()->month)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
            $table->selectRaw("
                SUM(IF(status_id IS NOT NULL, 1, 0 )) AS total_order,
                SUM(IF(status_id = 1, 1, 0)) AS status_1,
                SUM(IF(status_id = 2, 1, 0)) AS status_2,
                SUM(IF(status_id = 3, 1, 0)) AS status_3,
                SUM(IF(status_id = 4, 1, 0)) AS status_4,
                SUM(IF(status_id = 5, 1, 0)) AS status_5,
                SUM(IF(status_id = 6, 1, 0)) AS status_6
            ");
            $total_order_status = $table->first();

            $startDate = Carbon::now()->subDay(6)->toDateString();
            $orders = DB::table("orders")
                ->whereDate("created_at", ">=", $startDate)
                ->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
                ->orderBy("day")
                ->groupBy("day")
                ->get();
            $order_count = Order::whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())->count();

            $customers = DB::table("customers")->whereDate("created_at", ">=", $startDate)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
                ->orderBy("day")
                ->groupBy("day")
                ->get();
            $customer_count = Customer::count();

            $reservations = DB::table("reservations")
                ->whereDate("created_at", ">=", $startDate)
                ->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
                ->orderBy("day")
                ->groupBy("day")
                ->get();
            $reservation_count = Reservation::whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())->count();

            $car_bookings = DB::table("car_bookings")->whereDate("created_at", ">=", $startDate)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
                ->orderBy("day")
                ->groupBy("day")
                ->get();
            $car_booking_count = CarBooking::count();

            return view('home', compact(
                'customers',
                'order_count',
                'reservations',
                'reservation_count',
                'car_bookings',
                'car_booking_count',
                'customer_count',
                'order_days',
                'order_totals',
                'monthNow',
                'total_order_status',
                'order_statuses',
                'orders'
            ));
        }

        #Line chart
        $table = DB::table("orders")
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
            ->orderBy("day")
            ->groupBy("day")
            ->get();
        $order_days = $table->pluck("day")->toArray();
        $order_totals = $table->pluck("total")->toArray();

        #Text datetime
        $monthNow = Carbon::now()->isoFormat('MMMM Y');

        #
        $order_statuses = DB::table("order_statuses")->get(['id', 'name']);
        $table = DB::table("orders")
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->whereYear('created_at', '=', Carbon::now()->year);
        $table->selectRaw("
            SUM(IF(status_id IS NOT NULL, 1, 0 )) AS total_order,
            SUM(IF(status_id = 1, 1, 0)) AS status_1,
            SUM(IF(status_id = 2, 1, 0)) AS status_2,
            SUM(IF(status_id = 3, 1, 0)) AS status_3,
            SUM(IF(status_id = 4, 1, 0)) AS status_4,
            SUM(IF(status_id = 5, 1, 0)) AS status_5,
            SUM(IF(status_id = 6, 1, 0)) AS status_6
        ");
        $total_order_status = $table->first();

        #
        $startDate = Carbon::now()->subDay(6)->toDateString();
        $orders = DB::table("orders")->whereDate("created_at", ">=", $startDate)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
            ->orderBy("day")
            ->groupBy("day")
            ->get();
        $order_count = Order::count();

        $customers = DB::table("customers")->whereDate("created_at", ">=", $startDate)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
            ->orderBy("day")
            ->groupBy("day")
            ->get();
        $customer_count = Customer::count();

        $reservations = DB::table("reservations")->whereDate("created_at", ">=", $startDate)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
            ->orderBy("day")
            ->groupBy("day")
            ->get();
        $reservation_count = Reservation::count();

        $car_bookings = DB::table("car_bookings")->whereDate("created_at", ">=", $startDate)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as total'))
            ->orderBy("day")
            ->groupBy("day")
            ->get();
        $car_booking_count = CarBooking::count();

        return view('home', compact(
            'customers',
            'order_count',
            'reservations',
            'reservation_count',
            'car_bookings',
            'car_booking_count',
            'customer_count',
            'order_days',
            'order_totals',
            'monthNow',
            'total_order_status',
            'order_statuses',
            'orders'
        ));
    }
}
