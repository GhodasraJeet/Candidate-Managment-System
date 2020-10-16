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
    return view('login');
});
Route::get('login','LoginController@index')->name('login');
Route::post('login','LoginController@submitLogin')->name('submitLogin');
Route::get('logout','LoginController@logout')->name('logout');

Route::group(['middleware'=>'checkadmin'],function(){
    Route::get('home','AdminController@home')->name('home');
    Route::resource('hr','AdminHrController');
    Route::resource('admincandidate','AdminCandidateController');
    Route::resource('admincategory','AdminCategoryController');
});
Route::group(['middleware'=>'checkhr'],function(){
    Route::get('hrhome','HrController@home')->name('hrhome');
    Route::resource('hrcategory','HrCategoryController');
    Route::resource('hrinterview','InterviewController');
    Route::get('mycanidate','InterviewController@mycandidate')->name('hrinterview.mycandidate');
});
// Route::get('faltu','FaltuController@index')->name('faltu');

// Route::get('test/{name}',function($name){
//     return $name;
// })->where('name','[A-Za-z]+');
