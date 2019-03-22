<?php

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

// 登录
Route::match(['get', 'post'], 'login', 'Backend\LoginController@login');

// 需要登录才允许访问的路由
Route::middleware('back.login')->namespace('Backend')->group(function () {
    // 欢迎界面
    Route::get('welcome', 'LoginController@welcome');
    // 退出登录
    Route::get('logout', 'LoginController@logout');
    // 文章
    Route::match(['get', 'post'], 'article/index', 'ArticleController@index');
    Route::get('article/create', 'ArticleController@create');
    Route::post('article/save', 'ArticleController@save');
    Route::get('article/read/{id}', 'ArticleController@read');
    Route::get('article/operation', 'ArticleController@operation');
});


