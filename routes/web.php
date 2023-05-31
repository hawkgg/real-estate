<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
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


Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('{any?}', function() {
    $routeCollection = Route::getRoutes();
    $routes = [];
    foreach ($routeCollection as $route) {
        if (isset($route->action['as'])) {
            $route_uri = preg_replace("/{(.*?)}+/", ":$1", $route->uri);
            $routes[$route->action['as']] = $route_uri;
        }
    }

    $user = Auth::user();

    return view('app', [
        'user' => $user?->getData(),
        'backend_routes' => $routes,
    ]);
})->where('any', '.*');;
