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
        'quantity',
        ];

    public function scopeOrderIndex($query, $item_code, $delivery_user_id, $order_start, $order_end)
    {
        $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('client_companies', 'delivery_user_id', '=', 'client_companies.id');

        if (isset($item_code)) {
            $query->where('orders.item_code', $item_code);
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

    public function scopeAutoDeliveryIndex($query, $ship_date)
    {
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
