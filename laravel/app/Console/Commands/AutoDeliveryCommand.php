<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
use App\Services\AutoDeliveryService;
use Carbon\Carbon;

class AutoDeliveryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto_delivery {ship_date?}';

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
        $app_env = config('app.env');
        
        // heroku用スタート
        if ($app_env == 'heroku') {
            
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
            // heroku用終了

        //ローカル用　aws用
        } elseif ($app_env == 'local' || $app_env == 'production') {
            $ship_date = $this->argument("ship_date");
        }
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        $order_info = $order_indexes->pluck('ship_date')->toArray();

        if (empty($order_info)) {
            AutoDeliveryService::NoOrderSendMail($ship_date);
            return ;
        }

        AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
    }
}
