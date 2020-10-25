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

        $now_week = date('w', strtotime($now));

        if ($now_week == $saturday or $now_week == $sunday) {
            return ;
        }

        $ship_date = $now->addDay(2);

        $date_week = date('w', strtotime($ship_date));
        //TODO 可能であれば、祝日・長期連休の判定も入れたい

        if ($date_week == $saturday or $date_week == $sunday) {
            $ship_date = $ship_date->addDay(2);
        }

        $ship_date = $ship_date->toDateString();

        $schedule->command('command:auto_delivery '.$ship_date)
                 ->dailyAt('10:00')
                 ->appendOutputTo(dirname(dirname(dirname(__FILE__))) . '/storage/logs/SampleSchedule.log')
                 ->onSuccess(function () {
                     Log::info('成功');
                 })
                 ->onFailure(function () {
                     Log::error('エラー');
                 });
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
