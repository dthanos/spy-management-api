<?php

use App\Http\Controllers\SpyController;
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


Route::prefix('spy')->group(function() {
    Route::get('/', [SpyController::class, 'index']);
    Route::get('random', [SpyController::class, 'random'])->middleware('throttle:10,1');
//    Route::get('{spy}', [SpyController::class, 'show']);
//    Route::put('{spy}', [SpyController::class, 'update']);
    Route::post('/', [SpyController::class, 'store'])->middleware('auth');
//    Route::delete('{spy}', [SpyController::class, 'delete']);
});
