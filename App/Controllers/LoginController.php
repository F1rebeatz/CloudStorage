<?php

namespace App\Controllers;
use Kernel\Controller\Controller;

class LoginController extends Controller
{
    public function index():void {
        $this->view('login');
    }

    public function login() {
        $email = $this->request()->input('email');
        $password = $this->request()->input('password');

        $this->auth()->attempt($email, $password);
        return $this->redirect('/files/list');
    }

    public function logout() {
        $this->auth()->logout();
        return $this->redirect('/login');
    }
}