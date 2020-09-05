<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeOrderIndex($order_index)
    {
      	return $order_index
    		->where('item_id', '=' ,$params['item_id'])
    		->andwhereColumn('order_start', $params['order_start'] ,'<＝', 'delivery_date' ,'<＝','order_end',$params['order_end']);
    }
}