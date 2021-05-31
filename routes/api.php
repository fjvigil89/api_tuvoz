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


Route::post('login', 'Api\\AuthController@login')->name('login');


Route::post('Demologin', 'Api\\AuthController@Demologin')->name('Demologin');


Route::group(['middleware' => ['auth:sanctum', 'throttle:60,1']], function () {

    Route::get('getPatientNotTreatment', 'UserController@getPatientNotTreatment')->name('user.getPatientNotTreatment');
    Route::get('getAllpatient', 'UserController@getAllpatient')->name('user.getAllpatient');
    Route::get('countTreatment', 'TreatmentController@countTreatment')->name('treatment.countTreatment');
    Route::get('countUserByTreatment', 'TreatmentController@countUserByTreatment')->name('treatment.countUserByTreatment');

    Route::resource('treatment', 'TreatmentController',['only'=>[
        'index','store','show','update','destroy'
        ]]);   
    
    Route::resource('record', 'RecordController',['only'=>[
        'index','store','show','update','destroy'
        ]]);   
  
    Route::get('phrasePatientTreatment/{treatment}', 'TreatmentPatientController@phrasePatientTreatment')->name('treatment.phrasePatientTreatment');
    Route::get('countPatientTreatment', 'TreatmentPatientController@countPatientTreatment')->name('treatment.countPatientTreatment');
    Route::resource('treatment_patient', 'TreatmentPatientController',['only'=>[
        'index'
        ]]);  

    Route::post('update-password', 'Api\\UpdatePwdController@updatePassword')->name('updatePassword');    
    Route::post('logout', 'Api\\AuthController@logout')->name('api.logout');

    Route::post('treatment_status', 'TreatmentController@ChangeStatus')->name('treatment_status');
    Route::post('associatePatientTreatment', 'UserController@associatePatientTreatment')->name('associatePatientTreatment');
});

Route::post('register', 'Api\\AuthController@register')->name('api.register');
Route::post('forgot-password', 'Api\\PasswordController@fotgotPassword')->name('fotgotPassword');

//Para la aplicación movil, modo DEMO
Route::post('storeRecordFile', 'RecordController@storeRecordFile')->name('demo.storeRecordFile');



