<?php

/**
 * 二级域名
 */
Route::group(['domain' => '{service}.laravel-modules.com'], function () {
    Route::group(['namespace' => 'App\Modules'], function () {
        // 控制器在「App\Modules」命名空间

        Route::group(['namespace' => 'Domain\Http\Controllers'], function () {
            // 控制器在「App\Modules\Domain\Http\Controllers」命名空间
            Route::get('/', [
                'as' => 'domain1', 'uses' => 'DomainController@index'
            ]);
            Route::get('/hello', [
                'as' => 'domain1', 'uses' => 'DomainController@hello'
            ]);
        });
    });
});
