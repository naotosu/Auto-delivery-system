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
use App\Services\EditService;

class StockController extends Controller
{
    public function incoming()
    {
        return view('incoming');
    }

    public function order(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');

        $order_indexes = OrderItem::SearchByOrderList($item_code, $delivery_user_id, $order_start, $order_end)->paginate(15);

        return view('order', compact('order_indexes', 'item_code', 'delivery_user_id', 'order_start', 'order_end'));
    }

    public function temporary(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');

        $temporary_indexes = Inventory::TemporarySearchByStock($item_code,$delivery_user_id)->paginate(15);

        return view('temporary', compact('temporary_indexes', 'item_code', 'delivery_user_id'));
    }

    public function inventory(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');

        $stock_indexes = Inventory::SearchByStock($item_code, $delivery_user_id, $status)->paginate(15);

        return view('inventory', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status'));
    }

    public function inventory_csv_import(Request $request)
    {
        try {   
            InventoryCsvImportService::inventoryCsvImport($request);
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', 'CSVのデータのアップロード中断しました　製番＆束番に重複がある可能性があります');
            return redirect('/incoming');
        }
        session()->flash('flash_message', 'CSVの入荷品在庫データをアップロードしました');
        return redirect('/incoming');
    } 

    public function order_csv_import(Request $request)
    {
        try {   
            OrderItemCsvImportService::orderItemCsvImport($request);
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', 'CSVのデータのアップロード中断しました　同じ注文がある可能性があります（仮）');
            return redirect('/incoming');
        }
        session()->flash('flash_message', 'CSVの注文データをアップロードしました');
        return redirect('/incoming');
    } 
}
