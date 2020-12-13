<?php

Route::middleware('api')->namespace('Gowd\FileManager\Http\Controllers')->prefix(config('FileManager.route_prefix'))->group(function () {
    Route::get('test','DocumentController@test');
    Route::post(config('FileManager.route_name'), 'UploadController@store');
    Route::delete(config('FileManager.route_name'), 'UploadController@destroy');
    Route::get(config('FileManager.route_name'), 'UploadController@getFile');
});

