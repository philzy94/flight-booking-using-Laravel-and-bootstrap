<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/access-token', [FlightBookingController::class, 'stoaccessTokenre']);
Route::post('/flight-offers-search', [FlightBookingController::class, 'flightOffersSearch']);
Route::post('/flight-offers-price', [FlightBookingController::class, 'flightOffersPrice']);
Route::post('/flight-create-orders', [FlightBookingController::class, 'flightCreateOrders']);
