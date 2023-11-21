<?php

namespace Kernel\Router;

class Route
{
    private string $uri;
    private string $method;
    private $action;
    private array $middlewares = [];
    private array $parameters = [];

    public function __construct(string $uri, string $method, mixed $action, array $middlewares)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->action = $action;
        $this->middlewares = $middlewares;
        $this->extractParameters();
    }

    public static function get(string $uri, $action, array $middlewares = []):static{
        return new static($uri, 'GET', $action, $middlewares);
    }
    public static function post(string $uri, $action,  array $middlewares = []):static{
        return new static($uri, 'POST', $action, $middlewares);
    }
    public static function put(string $uri, $action,  array $middlewares = []):static{
        return new static($uri, 'PUT', $action, $middlewares);
    }
    public static function delete(string $uri, $action,  array $middlewares = []):static{
        return new static($uri, 'DELETE', $action, $middlewares);
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

    private function extractParameters(): void
    {
        preg_match_all('/{(\w+)}/', $this->uri, $matches);
        $this->parameters = $matches[1];
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
}