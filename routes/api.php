<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user();
        });

        // Since we'd likely have more endpoints around users, in reality it'd
        // make sense to use a resource route here instead of manually defining
        // this nested 'user.availability' endpoint.
        Route::prefix('{user}')->group(function () {
            Route::apiResource('availability', AvailabilityController::class)->only(['index']);
        });
    });
});
