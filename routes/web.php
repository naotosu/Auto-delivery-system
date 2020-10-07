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

Route::get('/incoming', 'StockController@incoming')->name('incoming');

Route::post('/order_imports', 'StockController@order_csv_import')->name('incoming');

Route::post('/inventory_imports', 'StockController@inventory_csv_import')->name('incoming');

Route::get('/order', 'StockController@order')->name('order');

Route::get('/orders', 'StockController@order_index')->name('order');

Route::get('/shipment/cancels', 'ShipmentCancelController@shipment_cancel')->name('cancel');

Route::get('/shipment/cancels/checks', 'ShipmentCancelController@shipment_cancel_check')->name('cancel');

Route::post('/shipment/cancels', 'ShipmentCancelController@shipment_cancel_execute')->name('cancel');

Route::get('/temporaries', 'StockController@temporary')->name('temporary');

Route::get('/stock', 'StockController@stock')->name('stock');

Route::get('/stocks', 'StockController@stock_index')->name('stock');

Route::get('/manager', 'UserController@manager')->name('manager');

/*Route::get('/notification_mail', function () {
    return view('notification_mail');
});*/

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
