<?php

use Illuminate\Support\Facades\Route;
use App\Treatment;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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

Route::get('openSmille', function () {    
    $count_features =25;
    $path = "storage/audio/106-a_h.wav";
    $python ="C:/Users/fjvigil/AppData/Local/Programs/Python/Python38/python.exe";
    $script = "{$python} C:/Users/fjvigil/Documents/sites/voicerecord/public/modelo/openSmall.py {$count_features} {$path} ";
    //dd("{$python} ../public/modelo/openSmall.py {$count_features} {$path} ");
    //$output = exec("{$python} ../public/modelo/openSmall.py {$count_features} \"{$path}\"");
    
    $process = new Process([$script]);

    $process->run();

    $process->isSuccessful();
    // executes after the command finishes
    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }

    dd($process->getOutput()) ;
})->name('web.openSmille');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');