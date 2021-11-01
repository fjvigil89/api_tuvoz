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
Route::post('webLogin', 'Api\\AuthController@webLogin')->name('weblogin');




Route::group(['middleware' => ['auth:sanctum', 'throttle:60,1']], function () {

    Route::resource('user', 'UserController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy'
    ]]);    
    //Specialist
    Route::get('getPatientNotTreatment', 'UserController@getPatientNotTreatment')->name('user.getPatientNotTreatment');
    Route::get('getAllpatient', 'UserController@getAllpatient')->name('user.getAllpatient');
    Route::get('countTreatment', 'TreatmentController@countTreatment')->name('treatment.countTreatment');
    Route::get('countUserByTreatment', 'TreatmentController@countUserByTreatment')->name('treatment.countUserByTreatment');
    Route::get('countGetRecordByUser', 'UserController@countGetRecordByUser')->name('user.countGetRecordByUser');
    Route::get('getRecordByUser', 'UserController@getRecordByUser')->name('user.getRecordByUser');


    Route::resource('treatment', 'TreatmentController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy'
    ]]);

    Route::resource('record', 'RecordController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy'
    ]]);    
    Route::resource('treatment_patient', 'TreatmentPatientController', ['only' => [
        'index'
    ]]);
    
    Route::get('countPatientTreatment', 'TreatmentPatientController@countPatientTreatment')->name('treatment.countPatientTreatment');


    Route::post('update-password', 'Api\\UpdatePwdController@updatePassword')->name('updatePassword');
    Route::post('logout', 'Api\\AuthController@logout')->name('api.logout');

    Route::post('treatment_status', 'TreatmentController@ChangeStatus')->name('treatment_status');
    Route::post('associatePatientTreatment', 'UserController@associatePatientTreatment')->name('associatePatientTreatment');

    Route::post('setEmailRegisterPatient', 'SendEmailController@setEmailRegisterPatient')->name('api.setEmailRegisterPatient');
    Route::post('setEmailRegisterSpecialist', 'SendEmailController@setEmailRegisterSpecialist')->name('api.setEmailRegisterSpecialist');

    //Admin
    Route::get('getAllTreatment', 'Admin\\AdminController@getAllTreatment')->name('admin.getAllTreatment');
    Route::get('countGetTreatment', 'Admin\\AdminController@countGetTreatment')->name('admin.countGetTreatment');
    Route::get('countGetUser', 'Admin\\AdminController@countGetUser')->name('admin.countGetUser');
    Route::get('getUser', 'Admin\\AdminController@getUser')->name('admin.getUser');
    Route::get('countGetRecord', 'Admin\\AdminController@countGetRecord')->name('admin.countGetRecord');
    Route::get('getAllRecord', 'Admin\\AdminController@getAllRecord')->name('admin.getAllRecord');

    //Apk
    Route::resource('app', 'AppController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy'
    ]]);  


    //Patient
    Route::get('phrasePatientTreatment/{treatment}', 'TreatmentPatientController@phrasePatientTreatment')->name('treatment.phrasePatientTreatment');
});

Route::post('register', 'Api\\AuthController@register')->name('api.register');
Route::get('pre_register', 'Api\\AuthController@pre_register')->name('api.pre_register');
Route::post('forgot-password', 'Api\\PasswordController@fotgotPassword')->name('fotgotPassword');

//Para la aplicación movil, modo DEMO
Route::post('storeRecordFile', 'RecordController@storeRecordFile')->name('demo.storeRecordFile');

//Obtener la Ultima Actualizacion
Route::get('lastUpdate', 'AppController@lastUpdate')->name('api.lastUpdate');
  

//Auth::routes();

//Organizar tabla Usuarios-Tratamientos
//Route::get('user_tratement_update', 'TreatmentPatientController@user_tratement_update')->name('api.user_tratement_update');