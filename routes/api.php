<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuoteController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/quote')->group(function () {
    //            url        controller            method
    Route::get('/quotes', [QuoteController::class, 'index']); // read all quotes
    Route::get('/quotes_per_UID/{uid}', [QuoteController::class, 'index_per_UID']); // read user quotes
    // Route::get('/quotes_per_UID', [QuoteController::class, 'index_per_UID']); // read user quotes
    Route::post('/store', [QuoteController::class, 'store']); // create a quote
    Route::put('/update/{id}', [QuoteController::class, 'update']); // update a quote
    Route::delete('/delete/{id}', [QuoteController::class, 'destroy']); // delete a quote
});


// ->middleware(['web'])
