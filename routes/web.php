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

/**
 * サイト表示
 */
// TOP
Route::get('/', 'RankingController@index');
Route::get('/ranking/{mode}', 'RankingController@index');

// このページについて
Route::get('/about', 'PagesController@about');

// アイディア投稿フォーム
Route::get('/ideaForm', 'IdeaFormController@index');
Route::post('/ideaForm/submit', 'IdeaFormController@submit');

// お問い合わせフォーム
//Route::get('/inquiryForm', 'inquiryFormController@index');
//Route::post('/inquiryForm/submit', 'InquiryFormController@submit');

Route::get('/thanks', 'PagesController@thanks');

// 広告入稿フォーム
Route::get('/adForm', 'AdFormController@index');
Route::post('/adForm/submit', 'AdFormController@submit');

// プレイヤー詳細
Route::get('/player/{player}', 'PlayerController@index');

// JMSログイン・ログアウト
Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Route::get('logout/{provider}',         'Auth\SocialAccountController@logout');

/**
 * 管理用ページ
 */
// TOP
Route::get('/admin', 'AdminController@index');

// お問い合わせ管理
//Route::get('/admin/inquiry', 'AdminController@inquiry');
//Route::get('/admin/inquiry/detail', 'AdminController@inquiry_detail');
//Route::post('/admin/inquiry/submit', 'AdminController@inquiry_submit');

// 広告管理
Route::get('/admin/ad', 'AdminController@ad_index');
Route::get('/admin/ad/preview', 'AdminController@ad_preview');
Route::post('/admin/ad/approve', 'AdminController@ad_approve');
Route::post('/admin/ad/delete', 'AdminController@ad_delete');

// アカウント管理
Route::get('/admin/account', 'AdminController@account');
// ログイン/ログアウト
Route::get('/admin/login', 'AdminController@login');
Route::get('/admin/logout', 'AdminController@logout');

Auth::routes();
