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
Route::get('/logout', 'UserController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', 'UserController@index')->name('dashboard');
	Route::get('/select', 'UserController@showCalendars')->name('select');
	Route::post('/select', 'UserController@selectCalendar')->name('submit-select');
	/*Route::get('/event-type/create', 'EventTypeController@create')->name('eventype-create');
	Route::post('/event-type/create', 'EventTypeController@store')->name('eventype-store');*/
	Route::resource('eventtype', 'EventTypeController');
});

Route::get('/schedule/{user}', 'ScheduleController@types')->name('types');
Route::get('/schedule/{user}/{eventType}/{start?}', 'ScheduleController@schedule')->name('schedule');
Route::get('/book/{user}/{eventType}/{datetime}', 'ScheduleController@book')->name('book');
Route::post('/book', 'ScheduleController@create')->name('create');
