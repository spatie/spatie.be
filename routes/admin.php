<?php

Route::redirectPermanent('admin', 'admin/postcards');

Route::get('admin/postcards', 'PostcardController@index');
Route::post('admin/postcards', 'PostcardController@store');
Route::delete('admin/postcards/{postcard}', 'PostcardController@delete');
