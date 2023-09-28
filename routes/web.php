<?php

use App\Http\Controllers\Admin\ApartmentController as ApartmentController;;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as DashboardController;
use App\Http\Controllers\Admin\LeadController as LeadController;
use App\Http\Controllers\Admin\SponsorController as SponsorController;
use App\Http\Controllers\Admin\PaymentsController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/', [ApartmentController::class,'index'])->name('dashboard');
    Route:: resource('apartments', ApartmentController::class);
    Route:: resource('leads', LeadController::class);
    Route:: resource('sponsors', SponsorController::class);
    Route::get('sponsors/create', [PaymentsController::class, 'create']);
    Route::get('sponsors/create/p', [PaymentsController::class, 'process'])->name('sponsor.process');
    Route::any('/payment/token', [PaymentController::class, 'token'])->name('payment.token');
    Route::get('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
