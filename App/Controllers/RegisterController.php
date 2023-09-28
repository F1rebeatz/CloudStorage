<?php

namespace App\Controllers;
use Kernel\Controller\Controller;

class RegisterController extends Controller
{
    public function index() {
        $this->view('register');
    }

    public function register() {

        $validation = $this->request()->validate([
            'name' => ['required', 'max:25'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8']
        ]);
        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/register');
        }
       $this->db()->insert('users', [
            'name' => $this->request()->input('name'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
        ]);

        $this->redirect('/files/list');
    }
}