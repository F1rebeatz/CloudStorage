<?php

namespace App\Kernel;
use App\Kernel\Http\Request;
use App\Kernel\Router\Router;

require_once APP_PATH . '/vendor/autoload.php';
class App
{
    public function run(): void
    {
        $router = new Router();
        $request = Request::createFromGlobals();
        $method = $request->method();
        $router->dispatch($request->uri(), $method);
    }

}