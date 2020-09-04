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
        $params = $request->orderIndex();

        $order_indexs = Order::serch($params)->get();

        return view('orders')->with([
            'order_indexs' => $order_indexs,
            'params' => $params,
        ]);
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
