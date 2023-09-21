<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Validator\Validator;

class FilesController extends Controller
{
    public function index(): void
    {
        header('Location: /files/list');
        $this->view('files');

    }

    public function list(): void
    {
        $this->view('files/list');
    }

    public function store(): void
    {
        $validation = $this->request()->validate([
            'name' => ['required']
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/files/list');
        }
    }
}
