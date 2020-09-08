<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function scopeOrderIndex($query, $item_id, $order_start, $order_end)
    {
      	if(!empty($item_id) and !empty($order_start) and !empty($order_end)) {

	      	return $query
	    		->where('item_id', $item_id)
	    		->whereBetween('orders.delivery_date', [$order_start, $order_end]);

	    } elseif (!empty($item_id)){

	   		 return $query
	   		 	->where('orders.item_id', $item_id);
	    		
	    } else {
	    	return $query
	    		->whereBetween('orders.delivery_date', [$order_start, $order_end]);
	    }
    }

    public function item()
    {
    	return $this->belongsTo('Item::class', 'item_id', 'item_id');
    }

    public function transport_company() 
    {
    	return $this->belongsTo('TransportCompany::class', 'transport_id','id');
    }
}