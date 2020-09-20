<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\Temporary;
use App\Services\TemporaryService;
use Carbon\Carbon;

class CsvController extends Controller
{
    public function temporary_ship(Request $request)
    {
        //$ship_date = $request->input('ship_date');
        //$change = $request->input('change');
        //$change_id = $request->input('change_id');
        //$item_ids = [$request->input('item_ids')];

        return TemporaryService::TemporaryIndex();
        
    }
}
