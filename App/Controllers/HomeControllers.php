<?php

namespace App\Controllers;

class HomeControllers
{
    public function index():void
    {
        include_once APP_PATH . '/App/Views/template_view.php';
    }
}