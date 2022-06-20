<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;

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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::get('user-profile', 'App\Http\Controllers\AuthController@userProfile');
    Route::post('sendPasswordResetLink', 'App\Http\Controllers\PasswordResetRequestController@sendEmail');
    Route::post('resetPassword', 'App\Http\Controllers\ChangePasswordController@passwordResetProcess');
    Route::post('post/{post_id}/comment/create','App\Http\Controllers\CommentController@create');
    Route::post('post/{id}/toggle-like','App\Http\Controllers\FileUploadController@toggle_like');
    Route::post('product/{product_id}/wishlist/create','App\Http\Controllers\WishlistController@create');
    Route::post('product/{product_id}/wishlist/delete','App\Http\Controllers\WishlistController@delete');

});

Route::post('sendEmail', 'App\Http\Controllers\MailController@sendEmail');
Route::post('file-upload','App\Http\Controllers\FileUploadController@fileUpload');
Route::post('store-product','App\Http\Controllers\ProductController@store');



