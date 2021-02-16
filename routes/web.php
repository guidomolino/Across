<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {return view('form'); }) -> name('form');

Route::post('/', 'FormController@store') -> name('form-store');
