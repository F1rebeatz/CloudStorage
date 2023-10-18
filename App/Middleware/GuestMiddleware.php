<?php

namespace App\Middleware;

class GuestMiddleware extends \Kernel\Middleware\AbstractMiddleware
{
    /**
     * @return void
     */
    public function handle(): void
    {
        if ($this->auth->check()) {
            $this->redirect->to('/home');
        }
    }
}