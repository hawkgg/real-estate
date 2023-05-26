<?php

use App\Http\Controllers\HouseController;
use App\Http\Controllers\VillageController;
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

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/', function () {
        return redirect()->route('villages.index');
    });

    Route::prefix('villages')->name('villages.')->group(function () {
        Route::get('/', [VillageController::class, 'index'])->name('index');
        Route::get('/{id}', [VillageController::class, 'show'])->name('show')->whereNumber('id');

        Route::get('/create', [VillageController::class, 'create'])->name('create')->middleware('permission:village.create');
        Route::post('/create', [VillageController::class, 'store'])->name('store')->middleware('permission:village.store');

        Route::get('/{id}/edit', [VillageController::class, 'edit'])->name('edit')->whereNumber('id')->middleware('permission:village.edit');
        Route::patch('/{id}/edit', [VillageController::class, 'update'])->name('update')->whereNumber('id')->middleware('permission:village.update');

        Route::delete('/{id}/delete', [VillageController::class, 'destroy'])->name('destroy')->whereNumber('id')->middleware('permission:village.delete');
    });

    Route::prefix('houses')->name('houses.')->group(function () {
        Route::get('/', [HouseController::class, 'index'])->name('index');
        Route::get('/{id}', [HouseController::class, 'show'])->name('show')->whereNumber('id');

        Route::get('/create', [HouseController::class, 'create'])->name('create')->middleware('permission:house.create');
        Route::post('/create', [HouseController::class, 'store'])->name('store')->middleware('permission:house.store');

        Route::get('/{id}/edit', [HouseController::class, 'edit'])->name('edit')->whereNumber('id')->middleware('permission:house.edit');
        Route::patch('/{id}/edit', [HouseController::class, 'update'])->name('update')->whereNumber('id')->middleware('permission:house.update');

        Route::delete('/{id}/delete', [HouseController::class, 'destroy'])->name('destroy')->whereNumber('id')->middleware('permission:house.delete');
    });
});

