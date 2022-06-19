<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show'])
  ->name('posts.show')
  ->whereNumber('post');

Route::get('signup', [SignUpController::class, 'index']);
Route::post('signup', [SignUpController::class, 'store']);

Route::get('mypage/login', [UserLoginController::class, 'index']);
Route::post('mypage/login', [UserLoginController::class, 'login']);
