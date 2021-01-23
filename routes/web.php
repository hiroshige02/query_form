<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
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
// 'Auth\LoginController@login'
// Route::post('/query', [SubController::class, 'query'])->name('query');
Route::get('/mailcheck1', [Controller::class, 'mailcheck1']);
Route::get('/mailcheck2', [Controller::class, 'mailcheck2']);
Route::get('/table', [Controller::class, 'table']);
