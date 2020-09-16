<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Inventory;
use App\OrderItem;
use App\Temporary;
use Carbon\Carbon;

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

        $order_indexes = OrderItem::orderIndex($item_code, $delivery_user_id, $order_start, $order_end)->get();

        return view('order', compact('order_indexes', 'item_code', 'delivery_user_id', 'order_start', 'order_end'));
    }

    public function compulsion()
    {
        return view('compulsion');
    }

    public function temporary(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');

        if (isset($item_code) or ($delivery_user_id)) {

            $temporary_indexes = Inventory::temporaryIndex($item_code,$delivery_user_id)->get();

            return view('temporary', compact('temporary_indexes', 'item_code', 'delivery_user_id'));

        }

        return view('temporary');
    }

    public function temporary_ship(Request $request)
    {
        $ship_date = $request->input('ship_date');
        $change = $request->input('change');
        $change_id = $request->input('change_id');
        $item_ids[] = $request->input('item_ids[]');

        return response()->streamDownload(
            function () {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');
                // ヘッダー
                fputcsv($stream, [
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
                foreach (Inventory::TemporaryIndex() as $temporary) {
                    fputcsv($stream, [
                        $temporary->order->delivery_user_id,
                        $temporary->order->clientCompanyDeliveryUser->name, 
                        $temporary->order_code,
                        $temporary->item->name,
                        $temporary->item->size, 
                        $temporary->item->shape, 
                        $temporary->item->spec,
                        $ship_date,
                        $temporary->manufacturing_code,
                        $temporary->bundle_number,
                        $temporary->weight,
                        $temporary->quantity,
                    ]);
                }
                fclose($stream);
            }, 
            'customers.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
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

        $stock_indexes = Inventory::stockIndex($item_code,$delivery_user_id,$status)->get();

        return view('stock', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status'));
    }
}
