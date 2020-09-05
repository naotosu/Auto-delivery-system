<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeOrderIndex($query, $item_id, $order_start, $order_end)
    {
      	return $query
    		->where('item_id', $item_id)
    		->andwhereColumn($order_start, '<＝', 'delivery_date' ,'<＝', $order_end);
    }
}