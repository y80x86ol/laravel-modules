<?php

/**
 * 二级域名
 */
Route::group(['domain' => '{subDomain}.laravel2.com'], function () {
    Route::group(['namespace' => 'App\Modules'], function () {
        // 控制器在「App\Modules」命名空间

        Route::group(['namespace' => 'DomainTest\Http\Controllers'], function () {
            // 控制器在「App\Modules\Domain\Http\Controllers」命名空间
            Route::get('/', [
                'as' => 'domain1', 'uses' => 'DomainTestController@index'
            ]);
            Route::get('/hello', [
                'as' => 'domain1', 'uses' => 'DomainTestController@hello'
            ]);
        });
    });
});
