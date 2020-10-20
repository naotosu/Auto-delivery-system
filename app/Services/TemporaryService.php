<?php

namespace App\Services;

use App\Models\Inventory;

class TemporaryService
{
	public static function TemporaryIndex($stream, $temporary_ships) {
	    fputcsv($stream, [
	                '配送業者ID',
	                '配送業者',
	                '担当',
	                '納品先コード',
	                '納品先',
	                'オーダーNo',
	                '鋼種',
	                'サイズ',
	                '単位',
	                '仕様',
	                '納入日',
	                'チャージ',
	                '製造No',
	                '結番',
	                '重量',
	                '本数',
	    ]);

		foreach ($temporary_ships as $temporary){
		            fputcsv($stream, [
		                $temporary->order->transport_id,
		                $temporary->order->transportCompany->name,
		                $temporary->order->transportCompany->stuff_name,
		                $temporary->order->delivery_user_id,
		                $temporary->order->clientCompanyDeliveryUser->name, 
		                $temporary->order_code,
		                $temporary->item->name,
		                $temporary->item->size, 
		                $temporary->item->shape, 
		                $temporary->item->spec,
		                $temporary->ship_date,
		                $temporary->charge_code,
		                $temporary->manufacturing_code,
		                $temporary->bundle_number,
		                $temporary->weight,
		                $temporary->quantity,
		            ]);
		}
		        
    }
}
