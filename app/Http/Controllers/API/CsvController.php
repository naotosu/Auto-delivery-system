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
        //TODO 出荷先を変更する機能を追加予定
        //$change = $request->input('change');
        //$change_id = $request->input('change_id');
        $item_ids = [$request->input('item_ids')];

        $temporary_ships = Inventory::TemporaryShipSearchByStock($item_ids)->get();

        $ship_arranged = \Config::get('const.Constant.ship_arranged');
        $temporary_ship_id = \Config::get('const.Constant.temporary_ship_id');

        //TODO Transaction設置予定（仮）

        foreach ($temporary_ships as $temporary_ship) {

            $temporary_ship->order_item_id = $temporary_ship_id;
            $temporary_ship->ship_date = $ship_date;
            $temporary_ship->status = $ship_arranged;
            $temporary_ship->save();

        }

        return response()->streamDownload(
            function () use ($temporary_ships) {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');
                // ヘッダー&データ

                TemporaryService::TemporaryIndex($stream, $temporary_ships);

                fclose($stream);
            },
            'ship'.date('Y-m-d H:m:s').'.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
    }  
}
