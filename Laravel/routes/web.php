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

Route::get('/homework', 'HomeWork@index')->middleware('auth');
Route::post('/add', 'HomeWork@add')->middleware('auth');
Route::post('/modosit', 'HomeWork@edit')->middleware('auth');
Route::post('/addszerelo', 'HomeWork@addszerelo')->middleware('auth');
Route::get('/munkalap/{id}', 'HomeWork@lap')->middleware('auth');

Route::post('/addalkat', 'HomeWork@addalkat')->middleware('auth');
Route::post('/addmunka', 'HomeWork@addmunka')->middleware('auth');

/*Route::get('/ossz', function () {
    return view('ossz');
})->middleware('auth');*/
Route::get('/ossz', 'HomeWork@keres')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
