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
        //$params = $request->orderIndex();

        $order_indexs = App\Order::orderIndex('item_id')->get();

        return view('orders', $order_indexs);
            
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
