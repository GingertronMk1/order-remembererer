<?php

use App\Http\Controllers\CuisineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorOrderController;
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

Route::middleware([
    'auth:sanctum',
    'verified',
    'ensure-team',
])->group(function () {
    Route::permanentRedirect('/', '/dashboard');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resources([
        'cuisine' => CuisineController::class,
        'vendor' => VendorController::class,
        'vendor.order' => VendorOrderController::class,
        'purchase' => PurchaseController::class
    ]);
});
