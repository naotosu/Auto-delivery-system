<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\Temporary;
use Carbon\Carbon;
use App\Services\InventoryCsvImportService;
use App\Services\OrderItemCsvImportService;

class InventoryController extends Controller
{
    public function inventory_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $order_id = $request->input('order_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');
        $status = $request->input('status');
        $normal_pagination = \Config::get('const.Constant.normal_pagination');

        $inventories = Inventory::SearchByStock($item_code, $order_id, $order_start, $order_end, $status)->paginate($normal_pagination);

        return view('inventory', compact('inventories', 'item_code', 'order_id', 'order_start', 'order_end', 'status'));
    }

    public function temporary(Request $request)
    {
        $item_code = $request->input('item_code');
        $normal_pagination = \Config::get('const.Constant.normal_pagination');

        $inventories = Inventory::TemporarySearchByStock($item_code)->paginate($normal_pagination);

        return view('temporary', compact('inventories', 'item_code'));
    }    

    public function inventory_csv_import(Request $request)
    {
        try {   
            InventoryCsvImportService::inventoryCsvImport($request);
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', 'CSVのデータのアップロード中断しました　製番＆束番に重複がある可能性があります');
            return redirect('/csv_imports');
        }
        session()->flash('flash_message', 'CSVの入荷品在庫データをアップロードしました');
        return redirect('/csv_imports');
    }

    public function shipment_cancel(Request $request)
    {
        $item_code = $request->input('item_code');
        $order_id = $request->input('order_id');
        $status = $request->input('status');
        $ship_date = $request->input('ship_date');
        $cancel_pagination = \Config::get('const.Constant.cancel_pagination');

        $inventories = Inventory::SipmentCancelSearch($item_code, $order_id, $status, $ship_date)->paginate($cancel_pagination);

        return view('cancel', compact('inventories', 'item_code', 'order_id', 'status', 'ship_date'));
    }

    public function shipment_cancel_check(Request $request)
    {
        $item_code = $request->input('item_code');
        $order_id = $request->input('order_id');
        $status = $request->input('status');
        $ship_date = $request->input('ship_date');

        $item_ids = $request->input('item_ids');
        $status_edit = $request->input('status_edit');
        $cancel_pagination = \Config::get('const.Constant.cancel_pagination');

        if (empty($status_edit)) {
            $inventories = Inventory::ShipmentCancelCheck($item_code, $order_id, $status, $ship_date)->paginate($cancel_pagination);
            session()->flash('flash_message', 'どこまで進捗を戻すか？は入力必須です');
            return view('cancel', compact('inventories', 'item_code', 'order_id', 'status', 'ship_date', 'item_ids'));
        }

        if (empty($item_ids)) {
            $inventories = Inventory::ShipmentCancelCheck($item_code, $order_id, $status, $ship_date)->paginate($cancel_pagination);
            session()->flash('flash_message', '出荷取消を行う対象を選択して下さい');
            return view('cancel', compact('inventories', 'item_code', 'order_id', 'status', 'ship_date', 'status_edit'));
        }

        $inventories = Inventory::ShipmentCancelCheck($item_ids)->get();

        return view('cancel_check', compact('inventories', 'item_ids', 'status', 'status_edit'));
    } 

    public function shipment_cancel_execute(Request $request)
    {
        $item_ids = $request->input('item_ids');
        $status_edit = $request->input('status_edit');

        try {   
            $inventories = Inventory::ShipmentCancelExecute($item_ids)->get();

            foreach ($inventories as $shipped){
                $shipped->status = $status_edit;
                $shipped->order_item_id = null;
                $shipped->order_id = null;
                $shipped->ship_date = null;
                $shipped->save();
            }

        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', '注文データの取消を中断しました');
            return redirect('/shipment/cancels');
        }
        session()->flash('flash_message', '出荷指示の取消を実行しました。必ず輸送会社へ連絡をして下さい');
        return redirect('/inventory/shipment/cancels');
    }
}
