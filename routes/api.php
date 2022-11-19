<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Backend\Auth\Register;
use App\Http\Controllers\API\Backend\Auth\Login;
use App\Http\Controllers\API\Backend\UploadController;
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

// Registered, activated, and is admin routes.
Route::middleware(['web'])->group( function () {
    // Route::resource('category', \App\Http\Controllers\API\Backend\CategoryController::class);
    Auth::routes();
    Route::resource('upload', \App\Http\Controllers\API\Backend\UploadController::class);
    // category wise Product
    Route::get('music', [\App\Http\Controllers\API\Backend\UploadController::class, 'music']);
    Route::get('comedy', [\App\Http\Controllers\API\Backend\UploadController::class, 'comedy']);
    Route::get('talent', [\App\Http\Controllers\API\Backend\UploadController::class, 'talent']);
    //Comments Route:
    Route::get('/comment/store', [\App\Http\Controllers\API\Backend\SocialController::class, 'commentStore']);
    Route::get('/reply/store', [\App\Http\Controllers\API\Backend\SocialController::class, 'replyStore']);
     //like Route
    Route::get('like/{id}', [\App\Http\Controllers\API\Backend\SocialController::class, 'likeStore']);
    Route::get('unlike/{id}', [\App\Http\Controllers\API\Backend\SocialController::class, 'unlike']);
      //follow Route
    Route::get('follow/{id}', [\App\Http\Controllers\API\Backend\SocialController::class, 'follow']);
    Route::get('unfollow/{id}', [\App\Http\Controllers\API\Backend\SocialController::class, 'unfollow']);

    Route::get('/all-followers', [\App\Http\Controllers\API\Backend\UploadController::class, 'get_all_followers']);
    Route::get('/{id}/followers', [\App\Http\Controllers\API\Backend\UploadController::class, 'get_followers']);

    Route::get('/{id}/total-likes', [\App\Http\Controllers\API\Backend\UploadController::class, 'get_total_likes']);
    Route::get('/{id}/likes', [\App\Http\Controllers\API\Backend\UploadController::class, 'get_likes']);
   
    // register
    Route::post('/register',[Register::class, 'register']);
    // login
    Route::post('/login',[Login::class, 'login']);
    Route::get('/logout',[Login::class, 'logout']);
    // video
    Route::get('/fetch_upload_data',[UploadController::class, 'fetch_upload_data']);


      // Site Settings Route.
    Route::get('site/settings', [\App\Http\Controllers\API\Backend\UploadController::class, 'talent']);
    Route::resource('menu', \App\Http\Controllers\API\Backend\UploadController::class);



});


