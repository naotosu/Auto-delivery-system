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

    public function compulsion()
    {
        return view('compulsion');
    }

    public function extraordinary()
    {
        return view('extraordinary');
    }





}
