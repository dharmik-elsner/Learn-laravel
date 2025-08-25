<?php

use App\Http\Middleware\RoleBasedMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(RoleBasedMiddleware::class);

Route::get('/homeofbuyer', function () {
    return view('homeofbuyer');
})->name('buyer.dashboard')->middleware(RoleBasedMiddleware::class);

Route::get('/homeofseller', function () {
    return view('homeofseller');
})->name('seller.dashboard')->middleware(RoleBasedMiddleware::class);   

