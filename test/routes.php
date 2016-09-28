<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::get('/example', function () {
    die("I am the test route for module");
});

Route::get('example/home', [
    'as' => 'profile', 'uses' => 'App\Modules\Example\Http\Controllers\ExampleController@index'
]);

Route::get('example/model', [
    'as' => 'profile', 'uses' => 'App\Modules\Example\Http\Controllers\ExampleController@model'
]);

/**
 * 推荐方法
 */
Route::group(['namespace' => 'App\Modules'], function() {
    // 控制器在「App\Modules」命名空间

    Route::group(['namespace' => 'Example\Http\Controllers'], function() {
        // 控制器在「App\Modules\Example\Http\Controllers」命名空间

        Route::get('example/view', [
            'as' => 'profile', 'uses' => 'ExampleController@view'
        ]);
    });
});
