<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('images', 'UploadController', [
    'only' => ['create', 'store']
]);

Auth::routes();

Route::get('/home', 'HomeController@index');
