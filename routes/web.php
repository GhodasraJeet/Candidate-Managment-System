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


Route::get('/','LoginController@index');
Route::get('login','LoginController@index')->name('login');
Route::post('login','LoginController@submitLogin')->name('submitLogin');
Route::get('logout','LoginController@logout')->name('logout');

//  Route for Admin

Route::group(['prefix'=>'admin','middleware'=>'checkadmin'],function(){
    Route::get('home','AdminController@home')->name('admin.home');
    Route::resource('hr','AdminHrController');
    Route::resource('candidates','AdminCandidateController');
    Route::resource('admincategory','AdminCategoryController');
    Route::get('candidatesreport','ReportController@viewCandidate')->name('viewcandidate');
    Route::get('hrreport','ReportController@viewHr')->name('viewhr');

    Route::get('create/plan', 'PlanController@createPlan')->name('create.plan');
    Route::post('store/plan', 'PlanController@storePlan')->name('store.plan');
    Route::get('/plans', 'PlanController@index')->name('plan.index');
    Route::get('plan/{id}/edit','PlanController@editplan')->name('plan.edit');
    Route::delete('plan/{id}','PlanController@deleteplan')->name('plan.destroy');
    Route::put('plan/{id}','PlanController@updateplan')->name('plan.update');
});
//  Route for HR

Route::group(['middleware'=>'checkhr'],function(){
    Route::get('home','HrController@home')->name('hr.home');
    Route::group(['middleware'=>'checksubscribe'],function(){
        Route::resource('category','HrCategoryController');
        Route::resource('interview','InterviewController');

    });
    Route::get('/plans', 'SubscriptionController@index')->name('plans.index');
    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');
    Route::get('/plan/{plan}', 'SubscriptionController@show')->name('plans.show');

    Route::get('plancancel','SubscriptionController@cancel')->name('cancel');
});


Route::get('example','FaltuController@ajaxData');
Route::get('getallData','FaltuController@loadallData')->name('getalldata');
Route::post('export', 'FaltuController@export')->name('export');


Route::get('downloadExcel/{type}', 'FaltuController@export');
