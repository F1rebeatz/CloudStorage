<?php

namespace App\Controllers;

use Kernel\Controller\Controller;

class HomeControllers extends Controller
{
    public function index():void
    {
       $this->view('home');
    }
}