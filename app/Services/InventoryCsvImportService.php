<?php

namespace App\Services;

use App\Models\Inventory;
use Carbon\Carbon;
use SplFileObject;

class InventoryCsvImportService
{
    protected $fillable = [
        'item_code',
        'order_code',
        'charge_code',
        'manufacturing_code',
        'bundle_number',
        'weight',
        'quantity',
        'status'
        ];

    public static function inventoryCsvImport($request)
    {     
        // ロケールを設定(日本語に設定)
        setlocale(LC_ALL, 'ja_JP.UTF-8');
     
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
                    ));
            }
            $row_count++;
        }       
    }
}
