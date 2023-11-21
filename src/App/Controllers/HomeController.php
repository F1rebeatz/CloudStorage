<?php

namespace App\Controllers;

use Kernel\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function index():void
    {
       $this->view('home', [], 'Home');
    }
}