<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
        $carbon = Carbon::now();
        $ship_date = $carbon->addDay(2)->toDateString();

        //TODO 祝日判定で更に+1日をループ　order_items重複防止策

        $schedule->command('command:auto_delivery '.$ship_date)
                 ->dailyAt('10:00')
                 ->appendOutputTo(dirname(dirname(dirname(__FILE__))) . '/storage/logs/SampleSchedule.log')
                 ->onSuccess(function () {
                     Log::info('成功');
                 })
                 ->onFailure(function () {
                     Log::error('エラー');
                 })
                 ;
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
}
