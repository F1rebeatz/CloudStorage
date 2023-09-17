<?php

namespace App\Controllers;

use App\Kernel\View\View;

class HomeControllers
{
    public function index():void
    {
        $view = new View();
        $view->page('template_view');
    }
}