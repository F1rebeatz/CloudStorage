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

       $lastId = $this->db()->insert('users', [
            'name' => $this->request()->input('name'),
            'email' => $this->request()->input('email'),
            'password' => password_hash($this->request()->input('password'), PASSWORD_DEFAULT),
        ]);

        $this->db()->insert('directories', [
            'user_id' => $lastId,
            'parent_directory_id' => null,
            'directory_name' => 'root',
        ]);

        if ($this->request()->input('check')) {
            $this->session()->set('user_id', $lastId);
            $this->redirect('/files/list');
        }

        $this->redirect('/files/list');
    }
}