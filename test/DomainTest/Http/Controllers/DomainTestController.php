<?php

/**
 * sub domain test controller
 */

namespace App\Modules\Domain\Http\Controllers;

use App\Http\Controllers\Controller;

class DomainController extends Controller {

    /**
     * home page
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
