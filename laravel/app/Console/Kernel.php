<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

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
        $saturday = \Config::get('const.Constant.saturday');
        $sunday = \Config::get('const.Constant.sunday');
        $now = Carbon::now();
        $ship_date = $now->addDay(2);

        //$date_week = date('w', strtotime($ship_date));

        //あえて土日テスト用変数
        $date_week = 6;

        if ($date_week == $saturday) {
            $ship_date = $ship_date->addDay(3);
        }

        if ($date_week == $sunday) {
            $ship_date = $ship_date->addDay(2);
        }

        $ship_date = $ship_date->toDateString();

        //TODO 祝日判定で更に+1日をループ　order_items重複防止策

        $schedule->command('command:auto_delivery '.$ship_date)
                 ->dailyAt('22:54')
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
