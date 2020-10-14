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
        ];

    public function scopeSearchByOrderList($query, $item_code, $delivery_user_id, $order_start, $order_end)
    {
        $query->join('orders', 'order_items.item_code', '=', 'orders.item_code');

        if (isset($item_code)) {
            $query->where('order_items.item_code', $item_code);
        }

        if (isset($delivery_user_id)) {
            $query->where('orders.delivery_user_id', $delivery_user_id);
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

        $query->where('ship_date', $ship_date)
                ->where('done_flag', $not_done);

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
