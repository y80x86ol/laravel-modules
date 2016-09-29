<?php

/**
 * 模块服务提供者
 */

namespace Y80x86ol\LaravelModules;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class LaravelModulesServiceProvider extends ServiceProvider {

    private $moduleName = '';
    private $modulesPath = '';
    private $currentModulePath = '';

    public function __construct($app) {
        parent::__construct($app);
    }

    /**
     * 启动服务提供者.
     *
     * @return void
     */
    public function boot(Request $request) {
        //初始值创建
        $this->getModulePath($request);

        //注册路由
        $this->registerMainRoute();

        if ($this->moduleName) {
            //注册路由
            $this->registerRoute();

            //注册视图
            $this->registerView();

            //注册语言包
            $this->registerTranslations();

            //注册配置文件
            $this->registerConfig();

            //注册静态资源
            $this->registerPublic();
        }
    }

    /**
     * 在容器中注册服务提供者.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('Modules', function ($app) {
            return new Module(config('modules'));
        });
    }

    /**
     * 获取模块信息
     * @param Request $request 请求类
     */
    private function getModulePath($request) {
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

        $this->moduleName = $moduleName;
        $this->modulesPath = base_path() . '/app/Modules/';
        $this->currentModulePath = $this->modulesPath . $moduleName . '/';
    }

    /**
     * 注册主路由
     */
    private function registerMainRoute() {
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
    private function registerRoute() {
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
    private function registerView() {
        $viewPath = $this->currentModulePath . 'Http/Views/';
        $this->loadViewsFrom($viewPath, $this->moduleName);

        //发布扩展包视图
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/courier'),
        ]);
    }

    /**
     * 注册语言包
     * 
     * 使用：echo trans('currentModuleName::messages.welcome');
     */
    private function registerTranslations() {
        $translationsPath = $this->currentModulePath . 'Translations/';
        $this->loadTranslationsFrom($translationsPath, $this->moduleName);

        //发布语言包
        $this->publishes([
            $translationsPath => base_path('resources/lang/vendor/courier'),
        ]);
    }

    /**
     * 注册独立模块配置文件
     *
     * 使用：$value = config('courier.option');
     */
    private function registerConfig() {
        $currentConfigPath = $this->currentModulePath . 'Config/app.php';
        if (file_exists($currentConfigPath)) {
            $this->publishes([
                $currentConfigPath => config_path('courier.php'),
            ]);
        }
    }

    /**
     * 注册静态资源
     *
     */
    private function registerPublic() {
        $publicPath = $this->currentModulePath . 'Public';
        $this->publishes([$publicPath => public_path('vendor/courier'),], $this->moduleName);
    }

}
