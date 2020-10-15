<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\Temporary;
use Carbon\Carbon;
use App\Services\InventoryCsvImportService;
use App\Services\OrderItemCsvImportService;

class InventoryController extends Controller
{
    public function temporary(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $nomal_pagination = \Config::get('const.Constant.nomal_pagination');

        $inventories = Inventory::TemporarySearchByStock($item_code,$delivery_user_id)->paginate($nomal_pagination);

        return view('temporary', compact('inventories', 'item_code', 'delivery_user_id'));
    }

    public function inventory_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');
        $nomal_pagination = \Config::get('const.Constant.nomal_pagination');

        $inventories = Inventory::SearchByStock($item_code, $delivery_user_id, $status)->paginate($nomal_pagination);

        return view('inventory', compact('inventories', 'item_code', 'delivery_user_id', 'status'));
    }

    public function inventory_csv_import(Request $request)
    {
        try {   
            InventoryCsvImportService::inventoryCsvImport($request);
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', 'CSVのデータのアップロード中断しました　製番＆束番に重複がある可能性があります');
            return redirect('/csv_imports');
        }
        session()->flash('flash_message', 'CSVの入荷品在庫データをアップロードしました');
        return redirect('/csv_imports');
    } 
}
