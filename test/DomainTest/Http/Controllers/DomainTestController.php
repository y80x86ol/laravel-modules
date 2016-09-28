<?php


namespace App\Modules\Domain\Http\Controllers;

use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    public function index() {
        echo "hello domain home page";
        die("over");
    }

    public function hello() {
        echo "hello domain1";
    }

}