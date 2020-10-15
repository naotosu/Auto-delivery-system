<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TopController@index')->name('top');

Route::get('/csv.imports', 'StockController@csv_imports')->name('csv_import');

Route::post('/order.imports', 'StockController@order_csv_import')->name('csv_import');

Route::post('/inventory.imports', 'StockController@inventory_csv_import')->name('csv_import');

Route::get('/orders/index', 'StockController@order')->name('order');

Route::get('/shipment/cancels', 'ShipmentCancelController@shipment_cancel')->name('cancel');

Route::get('/shipment/cancels/checks', 'ShipmentCancelController@shipment_cancel_check')->name('cancel');

Route::post('/shipment/cancels', 'ShipmentCancelController@shipment_cancel_execute')->name('cancel');

Route::get('/shipment/temporaries', 'StockController@temporary')->name('temporary');

Route::get('/inventories/index', 'StockController@inventory')->name('inventory');

Route::get('/manager', 'UserController@manager')->name('manager');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/archives/{category}/',function($category) {
    return view('archives.category',['category'=>$category]);
});
Auth::routes();

Route::get('/home', 'UserController@index')->name('home');
