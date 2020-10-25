<?php

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

Route::get('/','getAuthenticationController@index');

route::Get('show-Authentication','getAuthenticationController@show_Authentication');
route::get('/show-register','UserController@show_register');
route::post('/register-save','UserController@user_register');
route::get('/show-login','UserController@show_login');
route::post('/login','UserController@user_login');
route::get('/getAuthentication','getAuthenticationController@getAuthentication');
route::get('/getAccessToken','getAuthenticationController@getAccessToken');
route::get('/oauth2callback','getAuthenticationController@Auth_save');
route::get('getCampaignDetails','getAuthenticationController@getCampaignDetails');
