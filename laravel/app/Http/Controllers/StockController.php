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
        $orders = order::all();
        $data = ['orders' => $orders];
        return view('order', $data);
    }

    public function ordersindex(Request $request)
    {
        $item_id = $request->input('item_id');
        $order_start = $request->input('order_start');
        // $order_end = $request->input('order_end'); 

        $item_id = order::where('item_id','like','%'.$item_id.'%')->first();
        $order_start = order::where('date','like','%'.$order_start.'%')->first();
        // $order_end = order::where('date','like','%'.$order_end.'%')

        return view('ordersindex', ['item_ids'=>$item_id,'order_starts'=>$order_start]);
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
