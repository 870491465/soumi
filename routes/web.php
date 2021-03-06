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

Route::get('/login', [
    'as' => 'login',
    'uses' => 'UserController@getLogin'
]);

Route::post('/login', [
    'as' => 'postLogin',
    'uses' => 'UserController@postLogin'
]);

Route::get('/logout', 'UserController@logout');

Route::get('/register', [
   'as' => 'register',
    'uses' => 'UserController@getRegister'
]);

Route::get('/login/{mobil}', 'UserController@login');

Route::post('/register', [
   'as' => 'register',
    'uses' => 'UserController@postRegister'
]);

Route::post('/validator/{mobile}', 'UserController@validatorMobile');


Route::group(['prefix' => 'account', 'middleware' => ['auth']], function () {
    Route::get('/home', [
        'as' => 'home',
        'uses' => 'HomeController@index'
    ]);
    Route::get('/profile', 'AccountController@profile');
    Route::post('/profile', 'AccountController@postProfile');

    Route::get('/declaration', 'DeclarationController@index');
    Route::get('/declaration/create', 'DeclarationController@index');
    Route::post('/declaration', 'DeclarationController@store');

    Route::get('/customer/create', 'AccountController@create');
    Route::get('/customer', 'AccountController@index');
    Route::get('/customer/{id}', 'AccountController@show');
    Route::post('/customer', 'AccountController@store');
    Route::post('/customer/edit/{id}','AccountController@update');

    Route::get('/bank', 'AccountBankController@show');
    Route::post('/bank', 'AccountBankController@store');

    Route::get('/deposit', 'DepositController@index');
    Route::post('/deposit', 'DepositController@store');

    Route::get('/upgrade', 'UpgradeController@index');
    Route::post('/upgrade', 'UpgradeController@store');

    Route::get('/bonus', 'BonusController@index');

    Route::get('/transfer', 'TransferController@index');
    Route::get('/transfer/create', 'TransferController@create');
    Route::post('/transfer', 'TransferController@store');

    Route::get('/balance', 'BalanceController@index');

    Route::get('/setting', 'SettingController@index');

    Route::post('/setting/password', 'UserController@postChangePassword');

    Route::post('/upload', 'FileUploadController@store');

    Route::get('/bring', 'ZhuanzhangController@index');
    Route::get('/bring/create', 'ZhuanzhangController@create');
    Route::post('/bring/create', 'ZhuanzhangController@store');

});

/**
 * 管理后台
 */

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'namespace' => 'Admin'], function () {
    Route::get('/home', function() {
        return view('admin.deposit.index');
    });

    //认证审核
    Route::get('/authentication', 'AuthenticationController@index');

    Route::post('/authentication/{id}',[
        'as' => 'postAuthentication',
        'uses' => 'AuthenticationController@store'
    ]);

    Route::get('/declaration', 'DeclarationController@index');

    Route::get('/customer', 'CustomerController@index');
    Route::post('/account', 'CustomerController@store');
    Route::post('/customer/search', 'CustomerController@search');
    Route::get('/customer/upgrade', 'UpgradeHistoryController@index');
    Route::get('/customer/{id}', [
       'as' => 'getCustomer',
        'uses' => 'CustomerController@show'
    ]);
    Route::post('/customer/update/{id}', 'CustomerController@update');
    Route::get('/customer/setting/{id}', [
        'as' => 'settingCustomer',
        'uses' => 'CustomerController@setting'
    ]);
    /**
     * 用户升级
     */


    Route::get('/customer/upgrade/{id}', [
       'as' => 'customerUpgrade',
        'uses' => 'CustomerController@upgrade'
    ]);
    Route::post('/customer/upgrade/{id}', [
       'as' => 'postCustomerUpgrade',
        'uses' => 'CustomerController@postUpgrade'
    ]);

    Route::get('/customer/convert/{id}', [
        'as' => 'customerConvertAgent',
        'uses' => 'CustomerController@convertAgent'
    ]);

    Route::post('/customer/convert', 'CustomerController@postConvert');

    Route::get('/customer/hedge/{id}', [
       'as' => 'customerHedge',
        'uses' => 'CustomerController@hedgeAmount'
    ]);

    Route::post('/customer/hedge/{id}', [
        'as' => 'postCustomerHedge',
        'uses' => 'CustomerController@postHedgeAmount'
    ]);

    Route::get('/bonus', 'BonusController@index');
    Route::post('/bonus/search', 'BonusController@search');

    Route::get('/bonussetting', 'BonusSettingController@index');
    Route::post('/bonussetting', 'BonusSettingController@store');
    Route::post('/bounssetting/{id}', [
       'as' => 'postBonusEdit',
        'uses' => 'BonusSettingController@edit'
    ]);

    Route::get('/deposit', 'DepositController@index');
    Route::post('/deposit/{id}/delete', 'DepositController@delete');
    Route::get('/deposit/{id}', 'DepositController@show');
    Route::post('/deposit/{id}', 'DepositController@update');
    Route::post('/deposit/search', 'DepositController@search');

    Route::get('/upgrade/sms', 'DepositController@sendUpgradeMessage');
    Route::post('/upgrade/sms', 'DepositController@postSendUpgradeMessage');

    Route::get('/transfer', 'TransferController@index');
    Route::post('/transfer/search', 'TransferController@search');
    Route::post('/transfer/export', 'TransferController@export');
    Route::post('/transfer/success', 'TransferController@transferSuccess');
    Route::post('/transfer/update/{account_id}/{id}', 'TransferController@update');

    Route::get('/setting/smscontent', 'SmsContentController@show');
    Route::post('/setting/smscontent', 'SmsContentController@store');

    Route::get('/message', 'MessageController@index');
    Route::get('/message/create', 'MessageController@create');
    Route::post('/message/create', 'MessageController@store');

    Route::get('/setting', 'SettingController@index');
    Route::get('/setting/update/password', 'SettingController@updatePassword');
    Route::post('/setting/password', 'SettingController@postChangePassword');
    Route::get('/setting/depositamount', 'SettingController@depositAmount');
    Route::post('/setting/depositamount/{id}', 'SettingController@postDepositAmount');
});