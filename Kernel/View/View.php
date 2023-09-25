<?php

namespace Kernel\View;

use Kernel\Auth\AuthInterface;
use Kernel\Exceptions\ViewNotFoundException;
use Kernel\Session\SessionInterface;

class View implements ViewInterface
{
    public function __construct(
        private SessionInterface $session,
        private AuthInterface $auth
    )
    {

    }

    public function page(string $name): void
    {

        $filePath = APP_PATH . "/App/Views/pages/$name.php";

        if (!file_exists($filePath)) {
            throw new ViewNotFoundException("Views $name not found");
        }
        extract($this->defaultData());

        include_once $filePath;
    }

    public function component(string $name): void
    {
        $componentPath = APP_PATH . "/App/Views/components/$name.php";
        if (!file_exists($componentPath)) {
            echo "Component $name not found";
            return;
        }
        extract($this->defaultData());
        include_once $componentPath;
    }

    private function defaultData()
    {
        return [
            'view' => $this,
            'session' => $this->session,
            'auth' => $this->auth
        ];
    }

}