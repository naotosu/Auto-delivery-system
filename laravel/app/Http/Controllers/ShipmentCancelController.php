<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Carbon\Carbon;

class ShipmentCancelController extends Controller
{
    public function shipment_cancel(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');
        $ship_date = $request->input('ship_date');

        $stock_indexes = Inventory::SipmentCancelSearch($item_code, $delivery_user_id, $status, $ship_date)->paginate(10);

        return view('cancel', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status', 'ship_date'));
    }

    public function shipment_cancel_check(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');
        $ship_date = $request->input('ship_date');

        $item_ids = $request->input('item_ids');
        $status_edit = $request->input('status_edit');

        if (empty($status_edit)) {
        	$stock_indexes = Inventory::ShipmentCancelCheck($item_code, $delivery_user_id, $status, $ship_date)->paginate(10);
            session()->flash('flash_message', 'どこまで進捗を戻すか？は入力必須です');
            return view('cancel', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status', 'ship_date', 'item_ids'));
        }

        if (empty($item_ids)) {
        	$stock_indexes = Inventory::ShipmentCancelCheck($item_code, $delivery_user_id, $status, $ship_date)->paginate(10);
            session()->flash('flash_message', '出荷取消を行う対象を選択して下さい');
            return view('cancel', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status', 'ship_date', 'status_edit'));
        }

        $stock_indexes = Inventory::ShipmentCancelCheck($item_ids)->get();

        return view('cancel_check', compact('stock_indexes', 'item_ids', 'status', 'status_edit'));
    } 

    public function shipment_cancel_execute(Request $request)
    {
        $item_ids = $request->input('item_ids');
        $status_edit = $request->input('status_edit');

        try {   
            $stock_indexes = Inventory::ShipmentCancelExecute($item_ids)->get();

            foreach ($stock_indexes as $stock){
                $stock->status = $status_edit;
                $stock->order_item_id = null;
                $stock->ship_date = null;
                $stock->save();
            }

        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', '注文データの取消を中断しました');
            return redirect('/shipment/cancels');
        }
        session()->flash('flash_message', '出荷指示の取消を実行しました。必ず輸送会社へ連絡をして下さい');
        return redirect('/shipment/cancels');
    } 
}
