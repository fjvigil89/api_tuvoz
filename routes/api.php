<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('login', 'Api\\AuthController@login')->name('login');


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('treatment', 'TreatmentController',['only'=>[
        'index','store','show','update','destroy'
        ]]);   
    
    Route::post('update-password', 'Api\\UpdatePwdController@updatePassword')->name('updatePassword');    
    Route::post('logout', 'Api\\AuthController@logout')->name('api.logout');
});


Route::post('register', 'Api\\AuthController@register')->name('api.register');
Route::post('forgot-password', 'Api\\PasswordController@fotgotPassword')->name('fotgotPassword');




