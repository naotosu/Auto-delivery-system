<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Services\OrderItemCsvImportService;

class OrderController extends Controller
{
    public function csv_imports()
    {
        return view('csv_import');
    }

    public function order_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $order_id = $request->input('order_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');
        $nomal_pagination = \Config::get('const.Constant.nomal_pagination');

        $orders = OrderItem::SearchByOrderList($item_code, $order_id, $order_start, $order_end)->paginate($nomal_pagination);

        return view('order', compact('orders', 'item_code', 'order_id', 'order_start', 'order_end'));
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

    public function order_delete_check(Request $request)
    {
        $order_item_id = $request->input('order_item_id');

        $orders = OrderItem::SearchbyId($order_item_id)->get();

        return view('order_delete_check', compact('orders', 'order_item_id'));
    }

    public function order_delete_execute(Request $request)
    {
        $order_item_id = $request->input('order_item_id');

        try {

            OrderItem::SearchbyId($order_item_id)->delete();
        
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', '注文の消去を中断しました');
            return redirect('/orders');
        }
        session()->flash('flash_message', '注文の消去完了しました');
        return redirect('/orders');
    }
}
