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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['json.response']], function () {
    Route::post('login', 'api\UserController@login');
    Route::post('register', 'api\UserController@register');
    Route::post('logout','api\UserController@logout');
    Route::group(['middleware'=>['auth:api']],function(){
        Route::resource('category','api\CategoryController');
        Route::resource('candidate','api\CandidateController');
        Route::resource('hr','api\HrController');
    });
});

