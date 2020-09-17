<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class TemporaryService extends Model
{
	public function TemporaryHeader() {
		fputcsv($stream, [
			'納品先コード',
	        '納品先',
	        'オーダーNo',
	        '鋼種',
	        'サイズ',
	        '単位',
	        '仕様',
	        '納入日',
	        '製造No',
	        '結番',
	        '重量',
	        '本数',
        ]);
	}

	public function TemporaryIndex($query, $ship_date, $change, $change_id, $item_ids[]) {

	    foreach (Inventory::TemporaryShip($query, $ship_date, $change, $change_id, $item_ids[]) as $temporary) {
	    fputcsv($stream, [
            $temporary->order->delivery_user_id,
            $temporary->order->clientCompanyDeliveryUser->name, 
            $temporary->order_code,
            $temporary->item->name,
            $temporary->item->size, 
            $temporary->item->shape, 
            $temporary->item->spec,
            $ship_date,
            $temporary->manufacturing_code,
            $temporary->bundle_number,
            $temporary->weight,
            $temporary->quantity,
	    ]);
    }
}
