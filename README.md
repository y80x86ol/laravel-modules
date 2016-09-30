## laravel-modules
基于laravel5写的模块扩展，安装后可以进行模块化开发

## 安装

在你的项目中的composer.json文件中添加require:
<pre><code>
"require": {
        "y80x86ol/laravel-modules": "0.1.x-dev"
    },
</code></pre>

然后执行`composer update`下载和更新模块

## 使用

1、在app下新建文件夹Modules

2、在app/Modules中新建routes.php主路由文件

3、建立你的模块，在app/Modules中新建Example文件夹，模块名即为Example

4、在app/Modules/Example建立如下文件和文件夹，如下：
<pre><code>
Http\
    Controllers\    控制器
    Models\         模型
    Views\          视图
Public\             静态资源
Migrations\         数据库迁移
Translations\       国际化
routes.php          路由
example.php         模块配置文件[备注：该文件名字请和模块名字一下，单词全部小写]
</code></pre>

5、怎么样，上面的文件夹和文件是不是很熟悉，对了，你可以按照Laravel5的开发方式进行开发了，书写代码都是一样的

6、当你在增加一些静态资源或者数据库迁移或者国际化文件的时候，请在命令窗口执行 `php artisan vendor:publish` 进行相关文件的发布

##注意事项

1、模块中的路由写法最好采用路由组的写法，例如：
<pre><code>
Route::group(['namespace' => 'App\Modules\Example\Http\Controllers'], function() {
    // 控制器在「App\Modules\Example\Http\Controllers」命名空间

    Route::get('example/route', [
        'as' => 'profile', 'uses' => 'ExampleController@route'
    ]);

    Route::get('example/config', [
        'as' => 'profile', 'uses' => 'ExampleController@config'
    ]);
});
</code></pre>

## 演示模块

模块中的test文件夹中是附带有两个演示模块，你可以直接拷贝代码内容到app/Modules中

访问如下url地址，可以看到模块效果

`example.com/example/` 或者 `example.com/index.php/example`，这个取决于你的项目是否开启了去除index.php的配置

所有演示路由地址见模块中的routes.php文件