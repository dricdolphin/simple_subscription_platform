<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\User_subscriptionController;
use App\Http\Controllers\API\User_sent_postController;

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

Route::apiResource('process_new_post', PostController::class);
Route::apiResource('process_new_user_subscription', User_subscriptionController::class);
Route::apiResource('process_new_user_sent_post', User_sent_postController::class);