<?php

use App\Http\Controllers\Api\HouseController;
use App\Http\Controllers\Api\VillageController;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('villages/filter', [VillageController::class, 'filter'])->name('villages.filter');
    Route::resource('villages', VillageController::class);

    Route::get('houses/addditional-resources', [HouseController::class, 'getFilterAdditionalResources'])
        ->name('houses.getFilterAdditionalResources');
    Route::post('houses/filter', [HouseController::class, 'filter'])->name('houses.filter');
    Route::resource('houses', HouseController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
