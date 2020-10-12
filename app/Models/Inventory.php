<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'item_code',
        'order_code',
        'charge_code',
        'manufacturing_code',
        'bundle_number',
        'weight',
        'quantity',
        'status'
        ];

    public function scopeSearchByStock($query, $item_code, $delivery_user_id, $status)
    {
        $query->join('orders', 'inventories.item_code', '=', 'orders.item_code');

        if (isset($item_code)) {
            $query->where('inventories.item_code', $item_code);
        }

        if (isset($delivery_user_id)) {
            $query->where('orders.delivery_user_id', $delivery_user_id);
        }

        if (isset($status)) {
            $query->where('inventories.status', $status);
        }

        $query->oldest('warehouse_receipt_date');

        return $query;
    }

    public function scopeTemporarySearchByStock($query, $item_code, $delivery_user_id)
    {
        
        $query->join('orders', 'inventories.item_code', '=', 'orders.item_code')
            ->join('items', 'inventories.item_code', '=', 'items.item_code')
            ->join('client_companies', 'orders.end_user_id', 'client_companies.id');

        $factory_stock = \Config::get('const.Constant.factory_stock');
        $warehouse_stock = \Config::get('const.Constant.warehouse_stock');

        $query->where('inventories.status', $factory_stock)
            ->orwhere('inventories.status', $warehouse_stock);

        if (isset($item_code)) {
            $query->where('inventories.item_code', $item_code);

        }

        if (isset($delivery_user_id)) {
            $query->where('orders.delivery_user_id', $delivery_user_id);
        }

        $query->oldest('item_code')
            ->oldest('charge_code')
            ->oldest('order_code')            
            ->oldest('manufacturing_code')
            ->oldest('bundle_number');


        $query->select('inventories.id', 'inventories.item_code', 'items.name', 'inventories.order_code', 'inventories.charge_code', 'inventories.manufacturing_code', 'inventories.bundle_number', 'inventories.quantity', 'inventories.weight', 'inventories.status', 'inventories.production_date', 'inventories.factory_warehousing_date', 'inventories.warehouse_receipt_date', 'inventories.destination_id', 'orders.delivery_user_id');

        return $query;
    }

    //public function scopeTemporaryShipSearchByStock($query, $item_ids, $ship_date, $change, $change_id)
    public function scopeTemporaryShipSearchByStock($query, $item_ids)
    {

        /*if (isset($change)) {
            return ; （order_id変更メソッドを後程作成
        }*/

        foreach ($item_ids as $item_id) {
            $query->whereIn('inventories.id', $item_id);
        }

        $query->oldest('item_code')
            ->oldest('order_code')
            ->oldest('charge_code')
            ->oldest('manufacturing_code')
            ->oldest('bundle_number');

        return $query;
    }

    public function scopeSipmentCancelSearch($query, $item_code, $delivery_user_id, $status, $ship_date)
    {
        
        $query->join('orders', 'inventories.item_code', '=', 'orders.item_code')
            ->join('items', 'inventories.item_code', '=', 'items.item_code')
            ->join('client_companies', 'orders.end_user_id', 'client_companies.id');

        if (isset($status)) {
            $query->where('inventories.status', $status);

        } else {
            $ship_arranged = \Config::get('const.Constant.ship_arranged');
            $shipped = \Config::get('const.Constant.shipped');

            $query->where (function($query) use ($ship_arranged, $shipped) {
                $query->where('inventories.status', $ship_arranged)
                    ->orwhere('inventories.status', $shipped);
            });
        }

        if (isset($item_code)) {
            $query->where('inventories.item_code', $item_code);
        }

        if (isset($delivery_user_id)) {
            $query->where('orders.delivery_user_id', $delivery_user_id);
        }

        if (isset($ship_date)) {
            $query->where('inventories.ship_date', $ship_date);
        }

        $query->oldest('inventories.ship_date');

        $query->select('inventories.id', 'inventories.item_code', 'items.name', 'inventories.order_code', 'inventories.charge_code', 'inventories.manufacturing_code', 'inventories.bundle_number', 'inventories.quantity', 'inventories.weight', 'inventories.status', 'inventories.production_date', 'inventories.factory_warehousing_date', 'inventories.warehouse_receipt_date', 'inventories.destination_id', 'inventories.order_item_id', 'inventories.ship_date', 'orders.delivery_user_id');

        return $query;
    }

    public function scopeShipmentCancelCheck($query, $item_ids)
    {
        $query->join('orders', 'inventories.item_code', '=', 'orders.item_code')
            ->join('items', 'inventories.item_code', '=', 'items.item_code')
            ->join('client_companies', 'orders.end_user_id', 'client_companies.id');

        if (isset($status)) {
            $query->where('inventories.status', $status);

        } else {
            $ship_arranged = \Config::get('const.Constant.ship_arranged');
            $shipped = \Config::get('const.Constant.shipped');

            $query->where (function($query) use ($ship_arranged, $shipped) {
                $query->where('inventories.status', $ship_arranged)
                    ->orwhere('inventories.status', $shipped);
            });
        }

        if (isset($item_ids)) {
            
            $query->whereIn('inventories.id', $item_ids);
        }

        $query->oldest('inventories.ship_date');

        $query->select('inventories.id', 'inventories.item_code', 'items.name', 'inventories.order_code', 'inventories.charge_code', 'inventories.manufacturing_code', 'inventories.bundle_number', 'inventories.quantity', 'inventories.weight', 'inventories.status', 'inventories.production_date', 'inventories.factory_warehousing_date', 'inventories.warehouse_receipt_date', 'inventories.destination_id', 'inventories.order_item_id', 'inventories.ship_date', 'orders.delivery_user_id');

        return $query;
    }

    public function scopeSearchByItemCodeAndStatus($query, $order)
    {
        $factory_stock = \Config::get('const.Constant.factory_stock');
        $warehouse_stock = \Config::get('const.Constant.warehouse_stock');

        $query->where('inventories.item_code', $order->item_code)
            ->where(function($query) use ($factory_stock, $warehouse_stock){
                        $query->where('inventories.status', $factory_stock)
                            ->orwhere('inventories.status', $warehouse_stock);
                    })
            ->oldest('inventories.charge_code')
            ->oldest('inventories.order_code')
            ->oldest('manufacturing_code')
            ->oldest('bundle_number');

        return $query;
    }

    public function scopeSearchByShipArrangedList($query, $ship_date)
    {
        $ship_arranged = \Config::get('const.Constant.ship_arranged');

        $query->where('inventories.status', $ship_arranged)
            ->where('inventories.ship_date', $ship_date)
            ->oldest('inventories.item_code')
            ->oldest('inventories.order_code')
            ->oldest('inventories.manufacturing_code')
            ->oldest('inventories.bundle_number');

        return $query;

    }

    public function scopeShipmentCancelExecute($query, $item_ids) 
    {
        $query->whereIn('id', $item_ids);

        return $query;
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_code', 'item_code');
    }

    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItem');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'item_code', 'item_code');
    }

    public function clientCompany() 
    {
        return $this->belongsTo('App\Models\ClientCompany', 'delivery_user_id');
    }
}
