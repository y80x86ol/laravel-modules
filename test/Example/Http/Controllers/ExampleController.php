<?php

/**
 * 实例控制器
 */

namespace App\Modules\Example\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Example\Http\Models\ExampleModel;

class ExampleController extends Controller {

    public function __construct() {
        
    }

    /**
     * 首页
     */
    public function index() {
        return view('example::index');
    }

    /**
     * 展示视图和参数传递
     */
    public function view() {
        $data = [
            "name" => "example"
        ];
        return view('example::example.view', $data);
    }

    /**
     * 模块
     */
    public function model() {
        $exampleModel = new ExampleModel();
        $exampleModel->sayHello();
    }

    /**
     * 内部路由
     */
    public function route() {
        echo "<p>I am route for example route file<p>";
    }

    /**
     * 配置文件
     */
    public function config() {
        $config = config("example");
        var_dump($config);
    }

}
