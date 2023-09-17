<?php

namespace App\Kernel;

use App\Kernel\Container\Container;
use App\Kernel\Http\Request;
use App\Kernel\Router\Router;

require_once APP_PATH . '/vendor/autoload.php';

class App
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function run(): void
    {
        $this->container
            ->router
            ->dispatch(
                $this->container->request->uri(),
                $this->container->request->method()
            );
    }

}