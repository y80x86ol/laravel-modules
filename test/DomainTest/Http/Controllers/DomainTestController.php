<?php

/**
 * 二级域名测试
 */

namespace App\Modules\Domain\Http\Controllers;

use App\Http\Controllers\Controller;

class DomainController extends Controller {

    /**
     * 二级域名首页
     */
    public function index() {
        echo "hello sub domain home page";
    }

    /**
     * hello
     */
    public function hello() {
        echo "hello sub domain";
    }

}
