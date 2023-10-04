<?php

namespace App\Controllers;

use Kernel\Controller\Controller;

class HomeController extends Controller
{
    public function index():void
    {
       $this->view('home');
    }
}