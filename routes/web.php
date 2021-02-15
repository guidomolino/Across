<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {return view('form'); });
Route::post('/', 'FormController@store') -> name('store-message');
