<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::get('profile/create', 'Admin\ProfileController@add');
    Route::get('profile/edit', 'Admin\ProfileController@edit');
});

Route::group(['prefix' => 'rakuten'], function() {
    Route::get('rakuten/create', 'Rakuten\RakutenController@add');
    Route::get('rakuten/delete', 'Rakuten\RakutenController@delete');
    Route::get('rakuten/update', 'Rakuten\RakutenController@update');

