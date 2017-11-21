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

Route::get('/', 'HomeController@index')->name('login');
Route::get('/login', 'HomeController@login');

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', 'UserController@index');
	Route::get('/select', 'UserController@showCalendars');
	Route::post('/select', 'UserController@selectCalendar');
});

Route::get('/schedule/{user}/{eventType}/{start?}', 'ScheduleController@schedule')->name('schedule');
Route::get('/book/{user}/{eventType}/{datetime}', 'ScheduleController@book')->name('book');
Route::post('/book', 'ScheduleController@create')->name('create');