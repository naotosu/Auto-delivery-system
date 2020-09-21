<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Services\TemporaryService;
use Carbon\Carbon;
use App\Services\InventoryCsvImportService;
use SplFileObject;

class CsvController extends Controller
{
    protected $csvimport = null;
 
    /*public function __construct(CSVimport $csvimport)
    {
        $this->csvimport = $csvimport;
    }*/

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

    public function inventory_csv_import(Request $request)
    {
        //全件削除　？？
        //Inventory::truncate();
     
        // ロケールを設定(日本語に設定)
        setlocale(LC_ALL, 'ja_JP.UTF-8');
     
        // アップロードしたファイルを取得
        // 'csv_file' はビューの inputタグのname属性
        $uploaded_file = $request->file('csv_file');
     
        // アップロードしたファイルの絶対パスを取得
        $file_path = $request->file('csv_file');

        //SplFileObjectを生成
        $file = new SplFileObject($file_path);

        //SplFileObject::READ_CSV が最速らしい
        $file->setFlags(SplFileObject::READ_CSV);
       
        $row_count = 1;

        //取得したオブジェクトを読み込み
        foreach ($file as $row)
        {
            // 最終行の処理(最終行が空っぽの場合の対策
            if ($row === [null]) continue; 
            
            // 1行目のヘッダーは取り込まない
            if ($row_count > 1)
            {
                // CSVの文字コードがSJISなのでUTF-8に変更
                $item_code = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $order_code = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                $charge_code = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
                $manufacturing_code = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
                $bundle_number = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');
                $weight = mb_convert_encoding($row[5], 'UTF-8', 'SJIS');
                $quantity = mb_convert_encoding($row[6], 'UTF-8', 'SJIS');
                $status = mb_convert_encoding($row[7], 'UTF-8', 'SJIS');
                $production_date = mb_convert_encoding($row[8], 'UTF-8', 'SJIS');
                $factory_warehousing_date = mb_convert_encoding($row[9], 'UTF-8', 'SJIS');
                $warehouse_receipt_date = mb_convert_encoding($row[10], 'UTF-8', 'SJIS');
                $input_user_id = mb_convert_encoding($row[11], 'UTF-8', 'SJIS');
                
                //1件ずつインポート
                    Inventory::insert(array(
                        'item_code' => $row[0],
                        'order_code' => $row[1],
                        'charge_code' => $row[2],
                        'manufacturing_code' => $row[3],
                        'bundle_number' => $row[4],
                        'weight' => $row[5],
                        'quantity' => $row[6],
                        'status' => $row[7],
                        'production_date' => $row[8],
                        'factory_warehousing_date' => $row[9],
                        'warehouse_receipt_date' => $row[10],
                        'input_user_id' => $row[11],

                    ));
            }
            $row_count++;
        }
        
        return view('/incoming');
     
    }    
}
