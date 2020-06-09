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



Route::get('', 'LoginController@index');
Route::get('/logout', 'LoginController@logout')->name('logout');
Route::get('/uploader', 'HomeController@uploader')->name('uploader');
Route::get('/historical', 'HistoricalController@historical')->name('historical')->middleware('checkuser');
Route::post('/getHistoricalData', 'HistoricalController@getHistoricalData')->name('getHistoricalData')->middleware('checkuser');
Route::post('/getHistoricalData', 'HistoricalController@getHistoricalData')->name('getHistoricalData')->middleware('checkuser');
Route::post('/getHistoricalData_FB', 'HistoricalController@getHistoricalData_FB')->name('getHistoricalData_FB')->middleware('checkuser');

Route::post('/uploaded_history', 'HistoricalController@uploaded_history')->name('uploaded_history')->middleware('checkuser');
Route::post('/delete_row', 'HistoricalController@delete_row')->name('delete_row')->middleware('checkuser');
//twitter
Route::get('/toTwitter', 'LoginController@toTwitter')->name('toTwitter');
Route::get('/twcallback', 'LoginController@twAccessToken')->name('twcallback');
Route::get('/useranalytics', 'HomeController@useranalytics')->name('useranalytics')->middleware('checkuser');
Route::post('/getTwData', 'HomeController@get_twitter_data')->name('getTwData')->middleware('checkuser');

// facbook
Route::get('/home', 'HomeController@index')->middleware('checkuser');
Route::get('/anaylsis', 'AnaylsisController@index')->middleware('checkuser');
Route::get('/fbRedirect', 'FacebookController@fbRedirect')->name('fbRedirect')->middleware('checkuser');
Route::get('/test', 'FacebookController@test')->name('test')->middleware('checkuser');
Route::post('/getFbData', 'FacebookController@getFbData')->name('test')->middleware('checkuser');
