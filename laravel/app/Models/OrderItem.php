<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    
    protected $fillable = [
        'order_id',
        'item_code',
        'ship_date',
        'weight',
        'done_flag'
        ];

    public function scopeSearchByOrderList($query, $item_code, $order_id, $order_start, $order_end)
    {
        if (isset($item_code)) {
            $query->where('order_items.item_code', $item_code);
        }

        if (isset($order_id)) {
            $query->where('order_id', $order_id);
        }

        if (isset($order_start) and isset($order_end)) {
            $query->whereBetween('ship_date', [$order_start, $order_end]);
        }

        $query->oldest('ship_date');

        return $query;
    }

    public function scopeSearchByShipDate($query, $ship_date)
    {
        $not_done = \Config::get('const.Constant.not_done');

        $query->where('ship_date', $ship_date);

        return $query;
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_code', 'item_code');
    }

}
