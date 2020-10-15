<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
//use App\Models\Inventory;
use App\Models\OrderItem;
//use App\Models\Temporary;
use Carbon\Carbon;
//use App\Services\InventoryCsvImportService;
use App\Services\OrderItemCsvImportService;
//use App\Services\EditService;

class OrderController extends Controller
{
    public function csv_imports()
    {
        return view('csv_import');
    }

    public function order_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');
        $nomal_pagination = \Config::get('const.Constant.nomal_pagination');

        $orders = OrderItem::SearchByOrderList($item_code, $delivery_user_id, $order_start, $order_end)->paginate($nomal_pagination);

        return view('order', compact('orders', 'item_code', 'delivery_user_id', 'order_start', 'order_end'));
    }

    public function order_csv_import(Request $request)
    {
        try {   
            OrderItemCsvImportService::orderItemCsvImport($request);
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', 'CSVのデータのアップロード中断しました　同じ注文がある可能性があります');
            return redirect('/csv_imports');
        }
        session()->flash('flash_message', 'CSVの注文データをアップロードしました');
        return redirect('/csv_imports');
    } 
}
