<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Services\TemporaryService;
use Carbon\Carbon;
use App\Services\InventoryCsvImportService;

class CsvController extends Controller
{
    
    public function temporary_ship(Request $request)
    {
        //$ship_date = $request->input('ship_date');
        //$change = $request->input('change');
        //$change_id = $request->input('change_id');
        $item_ids = [$request->input('item_ids')];

        $temporary_ships = Inventory::TemporaryShip($item_ids)->get();

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
