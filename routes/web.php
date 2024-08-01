<?php

use App\Http\Controllers\Weather\IndexController;
use App\Http\Controllers\Weather\StoreController;
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
    return view('welcome');


});
Route::post('/weather', [StoreController::class, '__invoke'])->name('weather.store');
Route::get('/show', [IndexController::class, '__invoke'])->name('index');

