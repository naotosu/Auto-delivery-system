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

    public function scopeSearchByStock($query, $item_code, $order_id, $order_start, $order_end, $status)
    {
        if (isset($item_code)) {
            $query->where('item_code', $item_code);
        }

        if (isset($order_id)) {
            $query->where('order_id', $order_id);
        }

        if (isset($status)) {
            $query->where('inventories.status', $status);
        }

        if (isset($order_start) and isset($order_end)) {
            $query->whereBetween('ship_date', [$order_start, $order_end]);
        }

        $query->oldest('ship_date')
            ->oldest('order_code')
            ->oldest('warehouse_receipt_date');

        return $query;
    }

    public function scopeTemporarySearchByStock($query, $item_code)
    {
        $factory_stock = \Config::get('const.Constant.factory_stock');
        $warehouse_stock = \Config::get('const.Constant.warehouse_stock');

        $query->where (function($query) use ($factory_stock, $warehouse_stock) {
            $query->where('inventories.status', $factory_stock)
                ->orwhere('inventories.status', $warehouse_stock);
        });

        if (isset($item_code)) {
            $query->where('inventories.item_code', $item_code);

        }

        if (isset($order_items_id)) {
            $query->where('order_items_id', $order_items_id);
        }

        $query->oldest('item_code')
            ->oldest('charge_code')
            ->oldest('order_code')            
            ->oldest('manufacturing_code')
            ->oldest('bundle_number');

        return $query;
    }

    public function scopeTemporaryShipSearchByStock($query, $item_ids)
    {
        $query->whereIn('id', $item_ids);
        
        $query->oldest('item_code')
            ->oldest('order_code')
            ->oldest('charge_code')
            ->oldest('manufacturing_code')
            ->oldest('bundle_number');

        return $query;
    }

    public function scopeSipmentCancelSearch($query, $item_code, $order_id, $status, $ship_date)
    {
        if (isset($status)) {
            $query->where('status', $status);

        } else {
            $ship_arranged = \Config::get('const.Constant.ship_arranged');
            $shipped = \Config::get('const.Constant.shipped');

            $query->where (function($query) use ($ship_arranged, $shipped) {
                $query->where('status', $ship_arranged)
                    ->orwhere('status', $shipped);
            });
        }

        if (isset($item_code)) {
            $query->where('item_code', $item_code);
        }

        if (isset($order_id)) {
            $query->where('order_id', $order_id);
        }

        if (isset($ship_date)) {
            $query->where('ship_date', $ship_date);
        }

        $query->oldest('ship_date');

        return $query;
    }

    public function scopeShipmentCancelCheck($query, $item_ids)
    {
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

        return $query;
    }

    public function scopeSearchByItemCodeAndStatus($query, $order_item)
    {
        $factory_stock = \Config::get('const.Constant.factory_stock');
        $warehouse_stock = \Config::get('const.Constant.warehouse_stock');

        $query->where('inventories.item_code', $order_item->item_code)
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
        return $this->belongsTo('App\Models\Order');
    }
}
