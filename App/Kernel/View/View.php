<?php

namespace App\Kernel\View;

class View
{
    public function page(string $name):void {

        include_once APP_PATH . "/App/Kernel/View/pages/$name.php";
    }
}