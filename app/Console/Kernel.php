<?php

namespace App\Console;

use App\Console\Commands\Daily\RunAt0Hour\UpdateDailyCouponExperied;
use App\Console\Commands\Weekly\RunOnWed\ClearLogActivity;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('push:message')->everyMinute();
        $schedule->command('send-notification')->everyMinute();

        #region Daily
        //=== 0h
        $schedule->command(UpdateDailyCouponExperied::class)->dailyAt('00:01');

        #region Weekly
        $schedule->command(ClearLogActivity::class)->weeklyOn(3, '00:01');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
