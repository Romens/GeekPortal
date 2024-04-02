<?php

use App\Http\Controllers\Posts\PostsController;

Route::group(['namespace' => 'App\Http\Controllers\Posts'], function () {
    Route::get('posts', 'PostsController@index')->name('posts.index');
    Route::post('posts', 'PostsController@index')->name('posts.search');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('posts/create', 'PostsController@store')->name('posts.store');
        Route::patch('posts/{post}', 'PostsController@update')->name('posts.update');

        Route::group(['prefix' => 'posts'], function () {
            Route::controller(PostsController::class)->group(function () {
                Route::post('{post:id}/setReaction', 'setReaction')->name('posts.setReaction');
                Route::post('{post:id}/unsetReaction', 'unsetReaction')->name('posts.unsetReaction');
            });
        });
    });
});
