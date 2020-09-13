<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $table = 'order_items';

	public function scopeOrderIndex($query, $item_code, $delivery_user_id, $order_start, $order_end)
	{
		if (isset($item_code)) {
			$query->where('item_code', $item_code);
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

	public function order()
	{
	return $this->belongsTo('App\Order');
	}
	
	public function item()
	{
	return $this->belongsTo('App\Item', 'item_code', 'item_code');
	}
}
