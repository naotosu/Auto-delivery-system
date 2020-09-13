<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
	public function scopeStockIndex($query, $item_code, $delivery_user_id, $status)
	{
		if (isset($item_code)) {
			$query->where('item_code', $item_code);
		}

		if (isset($delivery_user_id)) {
			$query->where('orders.delivery_user_id', $delivery_user_id);
		}
		if (isset($status)) {
			$query->where('status', $status);
		}

		$query->oldest('warehouse_receipt_date');

		return $query;
	}

	public function item()
	{
		return $this->belongsTo('App\Item', 'item_code', 'item_code');
	}
	
	public function order()
	{
		return $this->belongsTo('App\Order', 'item_code', 'item_code');
	}

	public function clientCompany() 
	{
		return $this->belongsTo('App\ClientCompany', 'delivery_user_id', 'id');
	}
}
