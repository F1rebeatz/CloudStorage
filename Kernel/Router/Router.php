<?php

namespace Kernel\Router;
use Kernel\Auth\AuthInterface;
use Kernel\Database\DatabaseInterface;
use Kernel\Http\RedirectInterface;
use Kernel\Http\RequestInterface;
use Kernel\Middleware\AbstractMiddleware;
use Kernel\Session\SessionInterface;
use Kernel\Storage\StorageInterface;
use Kernel\View\ViewInterface;

class Router implements RouterInterface
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function __construct(
        private ViewInterface $view,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private SessionInterface $session,
        private DatabaseInterface $database,
        private AuthInterface $auth,
        private StorageInterface $storage
    )
    {
        $this->initRoutes();
    }

    public function initRoutes():void
    {
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }

    }

    public function dispatch(string $uri, string $method): void
    {

        $route = $this->findRoute($uri, $method);

        if (!$route) {
            $this->notFound();
        }

        if ($route->hasMiddlewares()) {
            foreach ($route->getMiddlewares() as $middleware) {
                /** @var \Kernel\Middleware\AbstractMiddleware $middleware */
                $middleware = new $middleware($this->request, $this->auth, $this->redirect);

                $middleware->handle();
            }
        }

        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();
            /** @var
             * Controller $controller
             */
            $controller = new $controller;

            call_user_func([$controller, 'setView'], $this->view);
            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setRedirect'], $this->redirect);
            call_user_func([$controller, 'setSession'], $this->session);
            call_user_func([$controller, 'setDatabase'], $this->database);
            call_user_func([$controller, 'setAuth'], $this->auth);
            call_user_func([$controller, 'setStorage'], $this->storage);
            call_user_func_array([$controller, $action], $route->getParameters());
        } else {
            $route->getAction()();
        }

    }

    private function notFound(): void
    {
        echo '404 Not found';
        exit();
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        if (!isset($this->routes[$method])) {
            return false;
        }

        // Сначала ищем маршруты с точным совпадением URI
        if (isset($this->routes[$method][$uri])) {
            return $this->routes[$method][$uri];
        }

        foreach ($this->routes[$method] as $route) {
            $routeUri = $route->getUri();
            $routeParts = explode('/', $routeUri);
            $uriParts = explode('/', $uri);

            if (count($routeParts) !== count($uriParts)) {
                continue;
            }

            $parameters = $this->extractParameters($routeUri, $uri);

            if (!empty($parameters)) {
                $route->setParameters($parameters);
                return $route;
            }
        }

        return false;
    }


    private function extractParameters(string $uriPattern, string $uri): array
    {
        $uriParts = explode('/', $uri);
        $patternParts = explode('/', $uriPattern);

        $parameters = [];

        foreach ($patternParts as $i => $patternPart) {
            if (strpos($patternPart, '{') === 0 && strpos($patternPart, '}') === strlen($patternPart) - 1) {
                $paramName = trim($patternPart, '{}');
                $parameters[$paramName] = $uriParts[$i];
            }
        }

        return $parameters;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return require_once APP_PATH . '/App/Config/routes.php';
    }
}