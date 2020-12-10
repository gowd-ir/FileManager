<?php

Route::middleware('api')->namespace('Gowd\FileManager\Http\Controllers')->prefix('api/document')->group(function () {
    // Route::apiResource('Profile1','ProfileController')->except(['edit','create']);
    Route::get('test','DocumentController@test');
//    Route::apiResource('User','UserController')->except(['edit','create']);

});
