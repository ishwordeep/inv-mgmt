<?php

use App\Http\Controllers\DistrictApiController;
use App\Http\Controllers\ProvinceApiController;
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

Route::get('/', function () {
    return redirect('/admin/dashboard');
});
Route::get('api/province/{country_id}', [ProvinceApiController::class, 'index']);
Route::get('api/district/{province_id}', [DistrictApiController::class, 'index']);

Route::get('load-new-tr-stock-entries',function(){
    return view("customViews/partialViews/newTrForStockEntries");
});

