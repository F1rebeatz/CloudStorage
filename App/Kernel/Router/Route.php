<?php

namespace App\Kernel\Router;

class Route
{
    private string $uri;
    private string $method;
    private $action;
    private array $middlewares = [];

    public function __construct(string $uri, string $method, mixed $action, array $middlewares)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->action = $action;
        $this->middlewares = $middlewares;
    }

    public static function get(string $uri, $action, array $middlewares = []):static{
        return new static($uri, 'GET', $action, $middlewares);
    }
    public static function post(string $uri, $action,  array $middlewares = []):static{
        return new static($uri, 'POST', $action, $middlewares);
    }

    function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getAction():mixed
    {

        return $this->action;
    }
    public function getMethod():string {
        return $this->method;
    }

    public function getMiddlewares():array {
        return $this->middlewares;
    }
    public function hasMiddlewares():bool {
        return !empty($this->middlewares);
    }
}