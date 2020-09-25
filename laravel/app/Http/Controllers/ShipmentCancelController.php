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

        if (isset($item_code) or ($delivery_user_id) or ($status) or ($ship_date)) {

            $stock_indexes = Inventory::editIndex($item_code, $delivery_user_id, $status, $ship_date)->get();

        return view('cancel', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status', 'ship_date'));
        }

        return view('cancel');
    }

    public function shipment_cancel_check(Request $request)
    {
        $item_ids = [$request->input('item_ids')];
        $status_edit = $request->input('status_edit');
        $stock_indexes = Inventory::editCheck($item_ids)->get();

        if (empty($status_edit)) {
            session()->flash('flash_message', 'どこまで進捗を戻すか？は入力必須です');
            return redirect('/shipment/cancels');
        }

        return view('cancel_check', compact('stock_indexes', 'item_ids', 'status_edit'));
    } 

    public function shipment_cancel_go(Request $request)
    {
        $item_ids = [$request->input('item_ids')];
        $status_edit = $request->input('status_edit');

        try {   
            Inventory::inventoryEdit($item_ids, $status_edit);
        } catch (\Exception $e) {
            report($e);
            session()->flash('flash_message', '注文データの取消を中断しました');
            return redirect('/shipment/cancels');
        }
        session()->flash('flash_message', '出荷指示の取消を実行しました。必ず輸送会社へ連絡をして下さい');
        return redirect('/shipment/cancels');
    } 
}
