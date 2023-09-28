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

        if ($this->auth()->attempt($email, $password)) {
            return $this->redirect('/files/list');
        }
        $this->session()->set('error', 'Invalid username or password');
        $this->redirect('/login');
    }

    public function logout() {
        $this->auth()->logout();
        return $this->redirect('/login');
    }
}