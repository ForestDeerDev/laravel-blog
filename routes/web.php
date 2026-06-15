<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

// 根路径跳转到登录页
Route::get('/', function () {
    return view("login");
});

// 登录页（GET）并命名为 login，供 auth 中间件跳转使用
Route::get('/login', function () {
    return view("login");
})->name('login');

// 登录处理（POST）
Route::post('/user/login', [UserController::class, 'login'])->name('login.post');

// 用户登出
Route::get('/user/loginoff', [UserController::class, 'loginoff']);

// 博客列表页（首页）
Route::get('/index', [BlogController::class, 'search']);

// 博客相关操作（需要登录验证）
Route::get('/blog/search', [BlogController::class, 'search']);
Route::post('/blog/add', [BlogController::class, 'add'])->middleware('auth');
// Route::get('/blog/del/{bid}', [BlogController::class, 'del'])->middleware('auth');
Route::delete('/blog/del/{bid}', [BlogController::class, 'del'])->middleware('auth');
Route::get('/blog/mod/{bid}', [BlogController::class, 'get'])->middleware('auth');
Route::post('/blog/mod', [BlogController::class, 'mod'])->middleware('auth');
