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
      	if (!empty($item_id) and !empty($delivery_user_id) and !empty($order_start) and !empty($order_end)) {

	      	return $query
	    		->where('item_id', $item_id)
	    		->where('delivery_user_id', $delivery_user_id)
	    		->whereBetween('orders.delivery_date', [$order_start, $order_end]);

	    } elseif (!empty($item_id) and !empty($delivery_user_id)) {

	      	return $query
	    		->where('item_id', $item_id)
	    		->where('delivery_user_id', $delivery_user_id);

	    } elseif (!empty($delivery_user_id) and !empty($order_start) and !empty($order_end)) {

	      	return $query
	    		->where('delivery_user_id', $delivery_user_id)
	    		->whereBetween('orders.delivery_date', [$order_start, $order_end]);

	    } elseif (!empty($item_id) and !empty($order_start) and !empty($order_end)) {

	      	return $query
	    		->where('item_id', $item_id)
	    		->whereBetween('orders.delivery_date', [$order_start, $order_end]);

	    } elseif (!empty($item_id)){

	   		 return $query
	   		 	->where('orders.item_id', $item_id);

	   	} elseif (!empty($delivery_user_id)){

	   		 return $query
	   		 	->where('delivery_user_id', $delivery_user_id);
	    		
	    } else {
	    	return $query
	    		->whereBetween('orders.delivery_date', [$order_start, $order_end]);
	    }
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