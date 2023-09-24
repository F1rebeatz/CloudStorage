<?php

namespace App\Kernel\View;

use App\Auth\AuthInterface;
use App\Kernel\Exceptions\ViewNotFoundException;
use App\Kernel\Session\Session;
use App\Kernel\Session\SessionInterface;

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

        $filePath = APP_PATH . "/App/Kernel/View/pages/$name.php";

        if (!file_exists($filePath)) {
            throw new ViewNotFoundException("View $name not found");
        }
        extract($this->defaultData());

        include_once $filePath;
    }

    public function component(string $name): void
    {
        $componentPath = APP_PATH . "/App/Kernel/View/components/$name.php";
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