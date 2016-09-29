<?php

/*
 * 模块主路由
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
