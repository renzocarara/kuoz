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

Route::prefix('/kuoz')->group(function () {
    //            url        controller            method
    Route::get('/quotes', [QuoteController::class, 'index']); // read all quotes
    Route::post('/quotes/{uid}', [QuoteController::class, 'index_UID']); // read quotes specifically for logged user
    Route::post('/store', [QuoteController::class, 'store']); // create a quote
    Route::put('/update/{id}', [QuoteController::class, 'update']); // update a quote
    Route::delete('/delete/{id}', [QuoteController::class, 'destroy']); // delete a quote
});
