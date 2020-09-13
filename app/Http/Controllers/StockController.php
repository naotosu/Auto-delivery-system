<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Inventory;
use App\OrderItem;
use Carbon\Carbon;

class StockController extends Controller
{
    public function incoming()
    {
        return view('incoming');
    }

    public function order()
    {
        return view('order');
    }

    public function order_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');

        $order_indexes = OrderItem::orderIndex($item_code, $delivery_user_id, $order_start, $order_end)->get();

        return view('order', compact('order_indexes', 'item_code', 'delivery_user_id', 'order_start', 'order_end'));
            
    }

    public function compulsion()
    {
        return view('compulsion');
    }

    public function extraordinary()
    {
        return view('extraordinary');
    }

    public function stock()
    {
        return view('stock');
    }

    public function stock_index(Request $request)
    {
        $item_code = $request->input('item_code');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');

        $stock_indexes = Inventory::stockIndex($item_code,$delivery_user_id,$status)->get();

        return view('stock', compact('stock_indexes', 'item_code', 'delivery_user_id', 'status'));
    }
}
