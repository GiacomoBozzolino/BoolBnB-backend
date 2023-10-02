<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\LeadController as LeadController;
use App\Http\Controllers\Api\ServiceController as ServiceController;
use App\Http\Controllers\Api\VisitorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Imposto la rota 

Route::get('/apartments', [ApartmentController::class, 'index']);
Route::get('/apartments/{slug}', [ApartmentController::class, 'show']);
Route::post('/contacts', [LeadController::class, 'store']);
Route::get('/search', [ApartmentController::class, "search"]);
Route::get('/searchAdvanced', [ApartmentController::class, "searchAdvanced"]);
Route::get('/services', [ServiceController::class, "index"]);
Route::get('sponsored-apartments', [ApartmentController::class, 'getFeaturedApartments']);
Route::post("/visitor/store", [VisitorController::class, "store"]);
