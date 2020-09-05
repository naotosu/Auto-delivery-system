<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

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
        $item_id = $request->input('item_id');
        $order_start = $request->input('order_start');
        $order_end = $request->input('order_end');

        $order_indexes = Order::orderIndex($item_id,$order_start,$order_end)->get();

        return view('order', compact('order_indexes'));
            
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



}
