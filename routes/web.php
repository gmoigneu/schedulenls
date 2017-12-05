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

Route::domain('{user}.'.config('app.domain'))->group(function () {
	Route::get('/', 'ScheduleController@types')->name('types');
	Route::get('/s/{eventType}/{start?}', 'ScheduleController@schedule')->name('schedule');
	Route::post('/s/{eventType}/{start?}', 'ScheduleController@setTimezone')->name('schedule-timezone');
	Route::get('/book/{eventType}/{datetime}', 'ScheduleController@book')->name('book');
	Route::post('/book', 'ScheduleController@create')->name('create');	
	Route::get('/confirm/{event}/{token}', 'ScheduleController@confirm')->name('confirm');	
});

Route::get('/', 'HomeController@index')->name('login');
Route::get('/login', 'HomeController@login');
Route::get('/logout', 'UserController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', 'UserController@index')->name('dashboard');
	Route::get('/select', 'UserController@showCalendars')->name('select');
	Route::get('/settings', 'UserController@showSettings')->name('settings');
	Route::post('/settings/slug', 'UserController@updateSlug')->name('settings-slug');
	Route::post('/settings/timezone', 'UserController@updateTimezone')->name('settings-timezone');
	Route::post('/select', 'UserController@selectCalendar')->name('submit-select');
	Route::get('/archive', 'UserController@archiveNotifications')->name('archive');
	Route::resource('eventtype', 'EventTypeController');
});


