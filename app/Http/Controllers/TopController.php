<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopController extends Controller
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
    public function index()
    {
        return view('top');
    }

    public function csv_imports()
    {
        return view('csv_import');
    }

    public function orders_download(Request $request) {

        return Storage::download('/csv_sample/order_items_sample.csv');
    }

    public function inventories_download(Request $request) {     
        
        return Storage::download('/csv_sample/inventories_sample.csv', $filename, $headers);
    }
}
