<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class stockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function incoming()
    {
        return view('incoming');
    }

    public function order()
    {
        return view('order');
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
