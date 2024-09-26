<?php

namespace App\Controllers;

use VirtaraCase\Controller\Controller;
use VirtaraCase\Route\Route;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home', ['routes' => Route::getRoutes()]);
    }

    public function test()
    {
        return $this->parameters;
    }
}