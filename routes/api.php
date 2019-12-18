<?php

Route::post('/register', 'AuthController@register');
Route::get('/user', 'AuthController@user');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');


Route::group(['prefix' => 'topics'], function() {
    Route::get('/', 'TopicController@index');
    Route::post('/', 'TopicController@store');
    Route::get('/{topic}', 'TopicController@show');
    Route::patch('/{topic}', 'TopicController@update');
    Route::delete('/{topic}', 'TopicController@destroy');

    // Post Route Group
    Route::group(['prefix' => '/{topic}/posts'], function() {
        Route::post('/', 'PostController@store');
        Route::get('/{post}', 'PostController@show');
        Route::patch('/{post}', 'PostController@update');
        Route::delete('/{post}', 'PostController@destroy');
    });
});
