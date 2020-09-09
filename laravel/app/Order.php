<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeOrderIndex($query, $item_id, $delivery_user_id, $order_start, $order_end)
    {
      	if (isset($item_id)) {
		    $query->where('item_id', $item_id);
		}

		if (isset($delivery_user_id)) {
		    $query->where('delivery_user_id', $delivery_user_id);
		}

		if (isset($order_start) and isset($order_end)) {
			$query->whereBetween('delivery_date', [$order_start, $order_end]);
		}

		return $query;
    }

    public function item()
    {
    	return $this->belongsTo('App\Item', 'item_id', 'item_id');
    }

    public function clientCompany() 
    {
    	return $this->belongsTo('App\ClientCompany', 'delivery_user_id','id');
    }
}