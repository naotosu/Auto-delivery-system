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
        Inventory::truncate();
     
        // ロケールを設定(日本語に設定)
        setlocale(LC_ALL, 'ja_JP.UTF-8');
     
        // アップロードしたファイルを取得
        // 'csv_file' はビューの inputタグのname属性
        $uploaded_file = $request->file('csv_file');
     
        // アップロードしたファイルの絶対パスを取得
        $file_path = $request->file('csv_file')->path($uploaded_file);

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
                $id = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $item_code = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                //$checkin_date = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
                //$total_price = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');*/
                
                //1件ずつインポート
                    Inventory::insert(array(
                        ‘id’ => $id,
                        ‘item_code’ => $row[1],
                    ));
            }
            $row_count++;
        }
        
        return view('/incoming');
     
    }
            /*$data = [
                ‘id’ => $line[0],
                ‘item_code’ => $line[1],
                /*‘order_code’ => $line[2],
                ‘charge_code’ => $line[3],
                ‘manufacturing_code’ => $line[4],
                ‘bundle_number’ => $line[5],
                ‘weight’ => $line[6],
                ‘quantity’ => $line[7],
                ‘status’ => $line[8],
                ‘production_date’ => $line[9],
                ‘factory_warehousing_date’ => $line[10],
                ‘warehouse_receipt_date’ => $line[11],
                ‘ship_date’ => $line[12],
                ‘destination_id’ => $line[13],
                ‘input_user_id’ => $line[14],
                ‘output_user_id’ => $line[15],
            ];*/
        
    
}
