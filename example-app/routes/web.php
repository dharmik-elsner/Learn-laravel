<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RoleBasedMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VehicleController;

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






Route::post('/save-website', [App\Http\Controllers\SellerController::class, 'saveWebsite'])->name('save.website');

Route::get('/add-website', [App\Http\Controllers\SellerController::class, 'formtoaddwebsite'])->name('form.add.website');

Route::get('/view-websites', [App\Http\Controllers\SellerController::class, 'viewWebsites'])->name('view.websites');

// Route::delete('website/{id}', [App\Http\Controllers\SellerController::class, 'destroy'])->name('website.destroy');

// Route::get('/website/{id}/edit', [App\Http\Controllers\SellerController::class, 'edit'])->name('website.edit');

Route::get('/index',function(){
    return view('seller.index');
})->name('seller.index');

Route::get('/viewdata', [App\Http\Controllers\SellerController::class, 'sellerData'])->name('seller.data');

Route::get('website/edit/{id}', [App\Http\Controllers\SellerController::class, 'editData'])->name('editData');
Route::get('website/delete/{id}', [App\Http\Controllers\SellerController::class, 'delete'])->name('website.delete');






Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('vehicles/data', [VehicleController::class, 'getData'])->name('vehicles.data');
Route::get('vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');