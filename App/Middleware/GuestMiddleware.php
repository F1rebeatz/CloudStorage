<?php

namespace App\Middleware;

class GuestMiddleware extends \App\Kernel\Middleware\AbstractMiddleware
{

    public function handle(): void
    {
        if ($this->auth->check()) {
            $this->redirect->to('/files/list');
        }
    }
}