<?php

use App\Http\Controllers\Api\NotificationController as ApiNotificationController;
use App\Http\Controllers\CuisineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseInvitationAcceptController;
use App\Http\Controllers\PurchasePdfController;
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

Route::resource('purchase-invitation', PurchaseInvitationAcceptController::class)->only('edit', 'update')->scoped([
    'purchase_invitation' => 'token',
]);

Route::middleware([
    'auth:sanctum',
    'verified',
    'ensure-team',
])->group(function () {
    Route::permanentRedirect('/', '/dashboard');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/purchase/{purchase}/pdf', PurchasePdfController::class)->name('purchase.pdf');

    Route::resources([
        'cuisine' => CuisineController::class,
        'vendor' => VendorController::class,
        'vendor.order' => VendorOrderController::class,
        'purchase' => PurchaseController::class,
    ]);

    Route::prefix('iapi/')->name('iapi.')->group(function () {
        Route::resources([
            'notification' => ApiNotificationController::class,
        ]);
    });
});
