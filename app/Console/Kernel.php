<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $this->cancelOvertimeOrder();//取消超时订单
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    //清除超时未支付订单
    private function cancelOvertimeOrder()
    {
        echo Carbon::now()."|Crontab:cancelOvertimeOrder->Start:\n";
        //TODO
        //system_log('CancelOvertimeOrder', Carbon::now(), 'App\Http\Kernel@cancelOvertimeOrder', 0, 'Crontab', '127.0.0.1');
        echo Carbon::now()."|Crontab:cancelOvertimeOrder->End.\n";
    }
}
