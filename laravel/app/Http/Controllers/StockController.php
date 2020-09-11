<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Inventorie;
use Carbon\Carbon;

class StockController extends Controller
{
    public function incoming()
    {
        return view('incoming');
    }

    public function order()
    {
        $now = Carbon::now();
        return view('order', compact('now'));
    }

    public function order_index(Request $request)
    {
        $now = Carbon::now();
        $item_id = $request->input('item_id');
        $delivery_user_id = $request->input('delivery_user_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');

        $order_indexes = Order::orderIndex($item_id,$delivery_user_id,$order_start,$order_end)->get();

        return view('order', compact('order_indexes','now','item_id','delivery_user_id','order_start','order_end'));
            
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
        $now = Carbon::now();
        return view('stock', compact('now'));
    }

    public function stock_index(Request $request)
    {
        $now = Carbon::now();
        $item_id = $request->input('item_id');
        $delivery_user_id = $request->input('delivery_user_id');
        $status = $request->input('status');

        $stock_indexes = Inventorie::stockIndex($item_id,$delivery_user_id,$status)->get();

        return view('stock', compact('stock_indexes','now','item_id','delivery_user_id','status'));
    }
}
