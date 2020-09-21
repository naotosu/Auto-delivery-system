<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;

class InventoryCsvImportService extends Model
{
	protected $fillable = [
        	'item_code',
            'order_code',
            'charge_code',
            'manufacturing_code',
            'bundle_number',
            'weight',
            'quantity',
            'status'
            ];

	public static function inventoryCsvImport()
    {
        
    }
    
}
