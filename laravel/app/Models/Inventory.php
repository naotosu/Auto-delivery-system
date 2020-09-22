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

    public function scopeStockIndex($query, $item_code, $delivery_user_id, $status)
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

    public function scopeTemporaryIndex($query, $item_code, $delivery_user_id)
    {
        
        $query->join('orders', 'inventories.item_code', '=', 'orders.item_code')
            ->join('items', 'inventories.item_code', '=', 'items.item_code')
            ->join('client_companies', 'orders.end_user_id', 'client_companies.id');

        $factory_stock = \Config::get('const.Temporaries.factory_stock');
        $warehouse_stock = \Config::get('const.Temporaries.warehouse_stock');

        $query->where('inventories.status', $factory_stock)
            ->orwhere('inventories.status', $warehouse_stock);

        if (isset($item_code)) {
            $query->where('inventories.item_code', $item_code);

        }

        if (isset($delivery_user_id)) {
            $query->where('orders.delivery_user_id', $delivery_user_id);
        }

        $query->oldest('charge_code');

        $query->select('inventories.id', 'inventories.item_code', 'items.name', 'inventories.order_code', 'inventories.charge_code', 'inventories.manufacturing_code', 'inventories.bundle_number', 'inventories.quantity', 'inventories.weight', 'inventories.status', 'inventories.production_date', 'inventories.factory_warehousing_date', 'inventories.warehouse_receipt_date', 'inventories.destination_id', 'orders.delivery_user_id');

        return $query;
    }

    //public function scopeTemporaryShip($query, $item_ids, $ship_date, $change, $change_id)
    public function scopeTemporaryShip($query, $item_ids)
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

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_code', 'item_code');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'item_code', 'item_code');
    }

    public function clientCompany() 
    {
        return $this->belongsTo('App\Models\ClientCompany', 'delivery_user_id', 'id');
    }
}
