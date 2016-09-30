<?php

/**
 * 模块服务提供者
 */

namespace Y80x86ol\LaravelModules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Y80x86ol\LaravelModules\FileSystem;

class LaravelModulesServiceProvider extends ServiceProvider
{

    private $moduleName = '';
    private $modulesPath = '';
    private $currentModulePath = '';
    private $allModulesNameList = [];

    public function __construct($app)
    {
        parent::__construct($app);
    }

    /**
     * 启动服务提供者.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        //获取所有模块名字
        $this->getAllModulesNameList();

        //获取模块数据
        $this->getModulePath($request);

        //注册主路由
        $this->registerMainRoute();

        //注册所有模块静态资源
        $this->registerPublic();

        //注册所有模块数据库
        $this->registerMigrations();

        //注册所有模块配置文件
        $this->registerConfig();

        //注册所有模块语言包
        $this->registerTranslations();

        if ($this->moduleName) {
            //注册路由
            $this->registerRoute();

            //注册视图
            $this->registerView();
        }
    }

    /**
     * 在容器中注册服务提供者.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Modules', function ($app) {
            return new Module(config('modules'));
        });
    }

    /**
     * 获取所有模块名字
     */
    private function getAllModulesNameList()
    {
        $allmodulesNameList = FileSystem::getAllModules();
        $this->allModulesNameList = $allmodulesNameList;
    }

    /**
     * 获取模块信息
     * @param Request $request 请求类
     */
    private function getModulePath($request)
    {
        //先判断是否是二级域名
        $modulesConfig = config("modules");
        if (isset($modulesConfig['sub_domain']) && array_key_exists($request->getHost(), $modulesConfig['sub_domain'])) {
            $moduleName = $modulesConfig['sub_domain'][$request->getHost()];
        } else {
            //通过URI地址获取当前路由指定模块
            $uri = trim($request->path(), '/');
            $uriArray = explode('/', $uri);
            $moduleName = current($uriArray);
        }

        $this->moduleName = strtolower($moduleName);
        $this->modulesPath = base_path() . '/app/Modules/';
        $this->currentModulePath = $this->modulesPath . $moduleName . '/';
    }

    /**
     * 注册主路由
     */
    private function registerMainRoute()
    {
        $moduleRoutePath = $this->modulesPath . 'routes.php';
        if (file_exists($moduleRoutePath)) {
            if (!$this->app->routesAreCached()) {
                require $moduleRoutePath;
            }
        }
    }

    /**
     * 注册独立模块路由
     */
    private function registerRoute()
    {
        $currentModuleRoutePath = $this->currentModulePath . 'routes.php';
        if (file_exists($currentModuleRoutePath)) {
            if (!$this->app->routesAreCached()) {
                require $currentModuleRoutePath;
            }
        }
    }

    /**
     * 注册视图
     *
     * 使用：return view('currentModuleName::car.view');
     */
    private function registerView()
    {
        $viewPath = $this->currentModulePath . 'Http/Views/';
        $this->loadViewsFrom($viewPath, $this->moduleName);

        //发布扩展包视图
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/courier'),
        ]);
    }

    /**
     * 注册所有模块语言包
     *
     * 使用：echo trans('currentModuleName::messages.welcome');
     */
    private function registerTranslations()
    {
        foreach ($this->allModulesNameList as $moduleName) {
            $translationsPath = $this->modulesPath . $moduleName . '/Translations';

            $moduleName = strtolower($moduleName);
            if (file_exists($translationsPath)) {
                $this->loadTranslationsFrom($translationsPath, $moduleName);

                //发布语言包
                $this->publishes([
                    $translationsPath => base_path('resources/lang/vendor/courier'),
                ]);
            }
        }
    }

    /**
     * 注册所有模块配置文件
     *
     * 使用：$value = config('courier.option');
     */
    private function registerConfig()
    {
        foreach ($this->allModulesNameList as $moduleName) {
            $configPath = $this->modulesPath . $moduleName . '/' . strtolower($moduleName) . '.php';

            $moduleName = strtolower($moduleName);
            if (file_exists($configPath)) {
                $this->publishes([
                    $configPath => config_path($moduleName . '.php'),
                ]);
            }
        }
    }

    /**
     * 注册所有模块静态资源
     *
     * 模块下的静态资源均发布到对应的模块名字下,且名字均为小写
     */
    private function registerPublic()
    {
        foreach ($this->allModulesNameList as $moduleName) {
            $publicPath = $this->modulesPath . $moduleName . '/Public';

            $moduleName = strtolower($moduleName);
            if (file_exists($publicPath)) {
                $this->publishes([$publicPath => public_path('modules/' . $moduleName),], $moduleName);
            }
        }
    }

    /**
     * 注册所有模块数据库迁移
     * 
     */
    private function registerMigrations()
    {
        foreach ($this->allModulesNameList as $moduleName) {
            $migrationsPath = $this->modulesPath . $moduleName . '/Migrations';
            if (file_exists($migrationsPath)) {
                $this->loadMigrationsFrom($migrationsPath);
            }
        }
    }

}
