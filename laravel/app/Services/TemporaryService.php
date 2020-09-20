<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;

class TemporaryService extends Model
{
	public static function TemporaryIndex(/*$ship_date, $change, $change_id, $item_ids*/) {

	    return fputcsv($stream, [
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
	                '製造No',
	                '結番',
	                '重量',
	                '本数',
	            ]);

	            // データ
	            $temporary_ships = Inventory::TemporaryShip(/*$item_ids*/)->get();

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
		                $temporary->manufacturing_code,
		                $temporary->bundle_number,
		                $temporary->weight,
		                $temporary->quantity,
		            ]);
		        }

		        
    }
}
