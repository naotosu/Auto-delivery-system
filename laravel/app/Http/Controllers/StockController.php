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

    public function order()
    {
        return view('order');
    }

    public function order_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');

        $order_indexes = OrderItem::SearchByOrder($item_code, $delivery_user_id, $order_start, $order_end)->get();

        return view('order', compact('order_indexes', 'item_code', 'delivery_user_id', 'order_start', 'order_end'));
    }

    public function temporary(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');

        if (isset($item_code) or ($delivery_user_id)) {

            $temporary_indexes = Inventory::TemporarySearchByStock($item_code,$delivery_user_id)->get();

            return view('temporary', compact('temporary_indexes', 'item_code', 'delivery_user_id'));

        }

        return view('temporary');
    }


    public function stock(Request $request)
    {
        return view('stock');
    }

    public function stock_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');

        $stock_indexes = Inventory::SearchByStock($item_code, $delivery_user_id, $status)->get();

        return view('stock', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status'));
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
