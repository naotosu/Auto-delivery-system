<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Services\OrderItemCsvImportService;
use App\Services\AutoDeliveryService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function order_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $order_id = $request->input('order_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');
        $normal_pagination = \Config::get('const.Constant.normal_pagination');

        $orders = OrderItem::SearchByOrderList($item_code, $order_id, $order_start, $order_end)->paginate($normal_pagination);

        return view('order', compact('orders', 'item_code', 'order_id', 'order_start', 'order_end'));
    }

    public function order_csv_import(Request $request)
    {
        try {   
            OrderItemCsvImportService::orderItemCsvImport($request);
        } catch (\Exception $e) {
            report($e);
            if ( $e->getMessage() == '登録の無い[item_code]' ){
                session()->flash('flash_message', 'CSVのデータのアップロード中断しました　登録の無い[item_code]が含まれています');
                return redirect('/csv_imports');
            } else {
                session()->flash('flash_message', 'CSVのデータのアップロード中断しました　同じ注文がある可能性があります');
                return redirect('/csv_imports');
            }
        }
        session()->flash('flash_message', 'CSVの注文データをアップロードしました');
        return redirect('/csv_imports');
    }

    public function order_delete_check(Request $request)
    {
        $order_item_id = $request->input('order_item_id');

        $orders = OrderItem::find([$order_item_id]);

        return view('order_delete_check', compact('orders', 'order_item_id'));
    }

    public function order_delete_execute(Request $request)
    {
        $order_item_id = $request->input('order_item_id');

        try {

            $orders = OrderItem::find($order_item_id);
            $orders->delete();
        
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', '注文の消去を中断しました');
            return redirect('/orders');
        }
        session()->flash('flash_message', '注文の消去完了しました');
        return redirect('/orders');
    }

    public function manual_delivery_execute(Request $request)
    {
        $ship_date = $request->input("ship_date");
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        $order_info = $order_indexes->pluck('ship_date')->toArray();

        if (empty($order_info)) {
            AutoDeliveryService::NoOrderSendMail($ship_date);
            session()->flash('flash_message', 'この日の注文はありません。実行結果をメールしました。');
            return redirect('/csv_imports');
        }

        AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        session()->flash('flash_message', '納入日'.$ship_date.'の出荷指示を手動で実行しました。実行結果をメールしました。');
        return redirect('/csv_imports');
    }
}
