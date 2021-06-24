<?php

use Illuminate\Support\Facades\Route;
use App\Treatment;

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
})->name('welcome');

Route::get('login', function () {    
    return view('auth.login');
})->name('web.login');


// Route::get('email', function () {    
//     return view('Email.registroPrevioPatiente');
// })->name('web.email');


//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
