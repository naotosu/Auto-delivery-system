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
    protected $signature = 'command:auto_delivery {ship_date}';

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
        $ship_date = $this->argument("ship_date");
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        $order_info = $order_indexes->pluck('ship_date')->toArray();

        if (empty($order_info)) {
            AutoDeliveryService::AutoDeliveryNoOrder($ship_date);
            return ;
        }

        AutoDeliveryService::AutoDeliveryExecute($ship_date, $order_indexes);
    }
}
