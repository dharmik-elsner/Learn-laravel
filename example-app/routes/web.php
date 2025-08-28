<?php

use App\Http\Middleware\Authenticate;
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

Route::get('/view/users', [App\Http\Controllers\UserController::class, 'viewUsers'])->name('view.users');

Route::get('/homeofbuyer', [App\Http\Controllers\HomeController::class, 'buyer'])->name('buyer.dashboard')->middleware(RoleBasedMiddleware::class);

Route::get('/homeofseller', [App\Http\Controllers\HomeController::class, 'seller'])->name('seller.dashboard')->middleware(RoleBasedMiddleware::class);

Route::delete('User/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');

Route::get('User/{id}/edit', [App\Http\Controllers\UserController::class, 'updatePage'])->name('updatepage');

Route::post('/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

Route::get('/temp', function(){
    return view('layouts.app');
});