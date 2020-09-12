<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
	public function scopeStockIndex($query, $item_id, $delivery_user_id, $status)
	{
		if (isset($item_id)) {
			$query->where('inventories.item_id', $item_id);
		}

		if (isset($delivery_user_id)) {
			$query->where('delivery_user_id', $delivery_user_id);
		}
		if (isset($status)) {
			$query->where('status', $status);
		}

		return $query;
	}

	public function item()
	{
		return $this->belongsTo('App\Item', 'item_id', 'item_id');
	}

	public function clientCompany() 
	{
		return $this->belongsTo('App\ClientCompany', 'delivery_user_id', 'id');
	}
}
