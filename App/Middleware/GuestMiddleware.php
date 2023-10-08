<?php

namespace App\Middleware;

class GuestMiddleware extends \Kernel\Middleware\AbstractMiddleware
{

    public function handle(): void
    {
        if ($this->auth->check()) {
            $this->redirect->to('/home');
        }
    }
}