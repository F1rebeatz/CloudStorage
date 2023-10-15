<?php

namespace App\Controllers;
use App\Services\DirectoryService;
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
            $userId = $this->auth()->user()->id();
            $rootDirectoryId = DirectoryService::rootDirectory($this->db(), $userId);
            $this->session()->set('root_directory_id', $rootDirectoryId);
            $this->redirect('/directories/get/' . $rootDirectoryId);
        }
        $this->session()->set('error', 'Invalid username or password');
        $this->redirect('/login');
    }


    public function logout() {
        $this->auth()->logout();
        return $this->redirect('/login');
    }
}