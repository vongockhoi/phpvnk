<?php

namespace App\Console\Commands\Daily\RunAt0Hour;

use App\Helpers\LoggingHelper;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Constants\Coupon as CouponConst;
use App\Constants\CouponCustomer as CouponCustomerConst;
use Illuminate\Support\Facades\DB;

class UpdateDailyCouponExperied extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateDailyCouponExperied';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job for 0H';

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
        DB::beginTransaction();
        try {
            #lay danh sach coupon co trang thai la ( hoat dong, dung ) qua han.
            $coupons = Coupon::whereRaw("status_id in (1,2) AND end_date < CURDATE()")->get();

            foreach ($coupons as $coupon) {
                #cap nhat coupon
                Coupon::where('id', $coupon->id)->update([
                    'status_id' => CouponConst::STATUS['EXPIRED'],
                ]);

                #cap nhat coupon customer
                CouponCustomer::where('coupon_id', $coupon->id)->update([
                    'status_id' => CouponCustomerConst::STATUS['EXPIRED'],
                ]);
            }

            #
            DB::commit();
        } catch (\Exception $e) {
            LoggingHelper::logException($e);
        }
    }
}
