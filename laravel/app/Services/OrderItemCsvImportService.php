<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Item;
use Carbon\Carbon;
use SplFileObject;
use \Exception;

class OrderItemCsvImportService
{
    public static function orderItemCsvImport($request)
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

        $items = item::all();

        $keyed = $items->mapWithKeys(function ($item) {
            return [$item['item_code'] => true];
        });

        //取得したオブジェクトを読み込み
        foreach ($file as $row)
        {
            // 最終行の処理(最終行が空っぽの場合の対策
            if ($row === [null]) continue; 
            
            // 1行目のヘッダーは取り込まない
            if ($row_count == 1) {
                $row_count++;
                continue;
            }

            if (isset($keyed[$row[1]])) {
                    // CSVの文字コードがSJISなのでUTF-8に変更
                    $order_id = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                    $item_code = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                    $ship_date = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
                    $quantity = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');

                    //1件ずつインポート
                        OrderItem::insert(array(
                            'order_id' => $row[0],
                            'item_code' => $row[1],
                            'ship_date' => $row[2],
                            'weight' => $row[3],
                        ));
            } else {
                throw new Exception('登録の無い[item_code]');
            }

           $row_count++;
             
        }       
    }  
}
