<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function incoming()
    {
        return view('incoming');
    }

    public function order()
    {
        $orders = DB::select('select * from orders');
        $data = ['msg' => '在庫一覧', 'orders' => $orders];
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
