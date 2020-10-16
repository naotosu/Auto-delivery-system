<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Services\TemporaryService;
use Carbon\Carbon;
use App\Services\InventoryCsvImportService;
use Illuminate\Support\Facades\DB;

class CsvController extends Controller
{
    
    public function temporary_ship(Request $request)
    {
        $ship_date = $request->input('ship_date');
        $order_id = $request->input('order_id');
        $item_ids = [$request->input('item_ids')];

        //APIではフラッシュメッセージ使えない為、処理に必要なデータ不足の場合、returnで処理を中断とした

        if(empty($order_id)){
            return redirect('/shipment/temporaries');
        }

        if(empty($ship_date)){
            return redirect('/shipment/temporaries');
        }

        if(empty($item_ids)){
            return redirect('/shipment/temporaries');
        }

        $inventories = Inventory::TemporaryShipSearchByStock($item_ids)->get();

        $ship_arranged = \Config::get('const.Constant.ship_arranged');
        $temporary_ship_id = \Config::get('const.Constant.temporary_ship_id');

        //TODO Transaction設置予定（仮）

        foreach ($inventories as $inventory) {

            $inventory->order_item_id = $temporary_ship_id;
            $inventory->order_id = $order_id;
            $inventory->ship_date = $ship_date;
            $inventory->status = $ship_arranged;
            $inventory->save();

        }

        return response()->streamDownload(
            function () use ($inventories) {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');
                // ヘッダー&データ

                TemporaryService::TemporaryIndex($stream, $inventories);

                fclose($stream);
            },
            'ship'.date('Y-m-d H:m:s').'.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
    }  
}
