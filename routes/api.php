<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api']],function(){
	Route::post('temporary_ships', 'API\CsvController@temporary_ship');
});

/*Route::group(['middleware' => ['api']],function(){
	Route::post('inventory_imports', 'API\CsvController@inventory_csv_import');
});*/	