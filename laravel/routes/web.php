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

Route::get('/csv_imports', 'OrderController@csv_imports')->name('csv_import');

Route::post('/order_imports', 'OrderController@order_csv_import')->name('csv_import');

Route::post('/inventory_imports', 'InventoryController@inventory_csv_import')->name('csv_import');

Route::get('/orders', 'OrderController@order_index')->name('order');

Route::get('/orders/delete_check', 'OrderController@order_delete_check')->name('order');

Route::delete('/orders/delete', 'OrderController@order_delete_execute')->name('order');

Route::get('/shipment/cancels', 'ShipmentCancelController@shipment_cancel')->name('cancel');

Route::get('/shipment/cancels/checks', 'ShipmentCancelController@shipment_cancel_check')->name('cancel');

Route::post('/shipment/cancels', 'ShipmentCancelController@shipment_cancel_execute')->name('cancel');

Route::get('/shipment/temporaries', 'InventoryController@temporary')->name('temporary');

Route::get('/inventories', 'InventoryController@inventory_index')->name('inventory');

Route::get('/manager', 'UserController@manager')->name('manager');

Auth::routes();

Route::get('/home', 'UserController@index')->name('home');
