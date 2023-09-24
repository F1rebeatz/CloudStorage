<?php

namespace App\Controllers;
use App\Kernel\Controller\Controller;
use App\Kernel\Http\Redirect;

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