<?php

namespace Kernel\View;

use Kernel\Auth\AuthInterface;
use Kernel\Exceptions\ViewNotFoundException;
use Kernel\Session\SessionInterface;
use Kernel\Storage\StorageInterface;

class View implements ViewInterface
{
    public function __construct(
        private SessionInterface $session,
        private AuthInterface $auth,
        private StorageInterface $storage
    )
    {

    }

    public function page(string $name, array $data = []): void
    {

        $filePath = APP_PATH . "/App/Views/pages/$name.php";
        if (!file_exists($filePath)) {
            throw new ViewNotFoundException("Views $name not found");
        }
        extract(array_merge($this->defaultData(), $data));

        include_once $filePath;
    }

    public function component(string $name, array $data = []): void
    {
        $componentPath = APP_PATH . "/App/Views/components/$name.php";
        if (!file_exists($componentPath)) {
            echo "Component $name not found";
            return;
        }
        extract(array_merge($this->defaultData(), $data));
        include_once $componentPath;
    }

    private function defaultData()
    {
        return [
            'view' => $this,
            'session' => $this->session,
            'auth' => $this->auth,
            'storage' => $this->storage
        ];
    }

}