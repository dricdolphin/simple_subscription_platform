<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\WebsiteController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\User_subscriptionController;
use App\Http\Controllers\API\User_sent_postController;
use App\Http\Controllers\SendMailController;
use App\Models\Website;
use App\Models\User;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', [UserController::class, 'index']);
Route::get('/website', [WebsiteController::class, 'index']);
Route::get('/post', [PostController::class, 'index']);
Route::get('/user_subscription', [User_subscriptionController::class, 'index']);

Route::get('/sendemails/{post_id}', function ($post_id) {
    $controller = new SendMailController(); // make sure to import the controller
    $controller->send_mail(['post_id' => $post_id]);
});


Route::get('/newpost', function () {
    $websites = Website::pluck('title','id')->toArray();
    
    return view('newpost')->with('websites',$websites);
});

Route::get('/subscribe', function () {
    $websites = Website::pluck('title','id')->toArray();
    $users = User::pluck('name','id')->toArray();
    
    return view('subscribe')->with('websites',$websites)
    ->with('users',$users);
});

Route::post('store-post', [PostController::class, 'store']);
Route::post('store-user_subscription', [User_subscriptionController::class, 'store']);
Route::post('store-user_sent_post', [User_sent_postController::class, 'store'])->name('store-user_sent_post');