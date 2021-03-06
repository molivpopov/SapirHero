<?php

use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', function (){
        return redirect()->route('play');
    })
        ->name('home');

    Route::get('/play', 'PlayController@index')
        ->name('play');

    Route::get('/new', 'PlayController@newGame')
        ->name('new');

    Route::get('/next', 'PlayController@turn')
        ->name('next');
});


