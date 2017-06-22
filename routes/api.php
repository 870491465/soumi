<?php

use Illuminate\Http\Request;

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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/deposit', 'PaymentApiController@store');

/**
 * 获取登录信息
 */
Route::get('/account/login/{mobile}', 'AccountApiController@userLogin');

/**
 * 用户升级
 */
Route::post('/account/promote', 'AccountApiController@promote');

/**
 *  获取用户余额
 */
Route::get('/account/balance/{mobile}', 'AccountApiController@accountBalance');

/**
 * 用户对冲
 */
Route::post('/account/hedge/{mobile}', 'AccountApiController@hedge');
