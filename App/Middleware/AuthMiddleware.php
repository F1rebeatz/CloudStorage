<?php

namespace App\Middleware;

use Kernel\Middleware\AbstractMiddleware;

class AuthMiddleware extends AbstractMiddleware
{

    public function handle(): void
    {
       if (!$this->auth->check()) {
           $this->redirect->to('/login');
       }
    }
}