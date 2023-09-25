<?php

namespace App\Controllers;

use Kernel\Controller\Controller;

class FilesController extends Controller
{
    public function index(): void
    {
       $this->redirect('files/list');

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
