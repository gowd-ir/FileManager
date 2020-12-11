<?php

Route::middleware('api')->namespace('Gowd\FileManager\Http\Controllers')->prefix('api/doc')->group(function () {
    // Route::apiResource('Profile1','ProfileController')->except(['edit','create']);
    Route::get('test','DocumentController@test');
//    Route::apiResource('User','UserController')->except(['edit','create']);
    Route::post(config('FileManager.route_name'), 'UploadController@store');
    Route::delete(config('FileManager.route_name'), 'UploadController@destroy');
});
