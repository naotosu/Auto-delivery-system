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

Route::get('/', 'TopController@index');

Route::get('/csv_imports', 'TopController@csv_imports');

Route::get('/csv_sample/order_items_sample.csv', 'TopController@orders_download');

Route::get('/csv_sample/inventories_sample.csv', 'TopController@inventories_download');

Route::post('/order_imports', 'OrderController@order_csv_import');

Route::post('/auto_delivery/manual_execute', 'OrderController@manual_delivery_execute');

Route::post('/inventory_imports', 'InventoryController@inventory_csv_import');

Route::get('/orders', 'OrderController@order_index');

Route::get('/orders/delete_check', 'OrderController@order_delete_check');

Route::delete('/orders/delete', 'OrderController@order_delete_execute');

Route::get('/inventory/shipment/cancels', 'InventoryController@shipment_cancel');

Route::get('/inventory/shipment/cancels/checks', 'InventoryController@shipment_cancel_check');

Route::post('/inventory/shipment/cancels', 'InventoryController@shipment_cancel_execute');

Route::get('/shipment/temporaries', 'InventoryController@temporary');

Route::get('/inventories', 'InventoryController@inventory_index');

Route::get('/manager', 'UserController@manager');

Auth::routes();

Route::get('/home', 'UserController@index');
