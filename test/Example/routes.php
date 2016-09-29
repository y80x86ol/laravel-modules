<?php

/**
 * 推荐方法
 */
Route::group(['namespace' => 'App\Modules\Example\Http\Controllers'], function() {
    // 控制器在「App\Modules\Example\Http\Controllers」命名空间

    Route::get('example/route', [
        'as' => 'profile', 'uses' => 'ExampleController@route'
    ]);

    Route::get('example/config', [
        'as' => 'profile', 'uses' => 'ExampleController@config'
    ]);
});

