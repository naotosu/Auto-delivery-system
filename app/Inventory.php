<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
	public function scopeStockIndex($query, $item_code, $delivery_user_id, $status)
	{
		$query->join('orders', 'inventories.item_code', '=', 'orders.item_code');

		if (isset($item_code)) {
			$query->where('inventories.item_code', $item_code);
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

	public function scopeTemporaryIndex($query, $item_code, $delivery_user_id)
	{
		
		$query->join('orders', 'inventories.item_code', '=', 'orders.item_code')
			->join('items', 'inventories.item_code', '=', 'items.item_code')
			->join('client_companies', 'orders.end_user_id', 'client_companies.id');

		$query->where('inventories.status', '2')
			->orwhere('inventories.status', '3');

		if (isset($item_code)) {
			$query->where('inventories.item_code', $item_code);

		}

		if (isset($delivery_user_id)) {
			$query->where('orders.delivery_user_id', $delivery_user_id);
		}

		$query->oldest('warehouse_receipt_date');

		$query->select('inventories.id', 'inventories.item_code', 'items.name', 'inventories.order_code', 'inventories.charge_code', 'inventories.manufacturing_code', 'inventories.bundle_number', 'inventories.quantity', 'inventories.weight', 'inventories.status', 'inventories.production_date', 'inventories.factory_warehousing_date', 'inventories.warehouse_receipt_date', 'inventories.destination_id', 'orders.delivery_user_id');

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
