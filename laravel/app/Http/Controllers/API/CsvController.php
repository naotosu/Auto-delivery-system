<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\Temporary;
use App\Services\TemporaryService;
use Carbon\Carbon;

class CsvController extends Controller
{
    public function temporary_ship(Request $request)
    {
        //$ship_date = $request->input('ship_date');
        //$change = $request->input('change');
        //$change_id = $request->input('change_id');
        //$item_ids = [$request->input('item_ids')];

        //return　TemporaryService::TemporaryIndex();
        return response()->streamDownload(
            function () {
                // 出力バッファをopen
                $stream = fopen('php://output', 'w');
                // 文字コードをShift-JISに変換
                stream_filter_prepend($stream,'convert.iconv.utf-8/cp932//TRANSLIT');
                // ヘッダー
                fputcsv($stream, [
                    '配送業者ID',
                    '配送業者',
                    '担当',
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
                $temporary_ships = Inventory::TemporaryShip()->get();

                foreach ($temporary_ships as $temporary){
                    fputcsv($stream, [
                        $temporary->order->transport_id,
                        $temporary->order->transportCompany->name,
                        $temporary->order->transportCompany->stuff_name,
                        $temporary->order->delivery_user_id,
                        $temporary->order->clientCompanyDeliveryUser->name, 
                        $temporary->order_code,
                        $temporary->item->name,
                        $temporary->item->size, 
                        $temporary->item->shape, 
                        $temporary->item->spec,
                        $temporary->ship_date,
                        $temporary->manufacturing_code,
                        $temporary->bundle_number,
                        $temporary->weight,
                        $temporary->quantity,
                    ]);
                }

                fclose($stream);
            },
            'ship'.date('Y-m-d H:m:s').'.csv',
            [
                'Content-Type' => 'application/octet-stream',
            ]
        );
    }
}
