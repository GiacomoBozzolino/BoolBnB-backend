<?php

use App\Http\Controllers\Admin\ApartmentController as ApartmentController;;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as DashboardController;
use App\Http\Controllers\Admin\LeadController as LeadController;
use App\Http\Controllers\Admin\SponsorController as SponsorController;
use App\Http\Controllers\Admin\PaymentController as PaymentController;
use App\Http\Controllers\Admin\VisitorController as VisitorController;

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
    Route::get('sponsors/create', [PaymentController::class, 'create']);
    Route::get('sponsors/create', [PaymentController::class, 'process'])->name('sponsor.process');
    Route::any('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::any('/payment/token', [PaymentController::class, 'token'])->name('payment.token');
    Route::get('/statistic', [VisitorController::class, 'index'])->name('statistic.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
