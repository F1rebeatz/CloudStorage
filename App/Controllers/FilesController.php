<?php

namespace App\Controllers;

use App\Services\DirectoryService;
use App\Services\FileService;
use Kernel\Controller\Controller;
use Kernel\Database\DatabaseInterface;

class FilesController extends Controller
{
    public function index(): void
    {
        $directoryId = $this->request()->query('id', 0);

        $fileService = new FileService();
        $directoryService = new DirectoryService();

        $fileService->setDatabase($this->db());
        $directoryService->setDatabase($this->db());

        $currentDirectory = $directoryService->findDirectory($directoryId, $this->session()->get('user_id')) ?? null;

        if (!$currentDirectory) {
            $this->view('error', [
                'message' => 'Directory not found',
            ]);
            return;
        }

        $files = $fileService->getFilesInDirectory($directoryId);
        $subdirectories = $directoryService->getSubdirectories($directoryId);

       $this->view('files/list', [
            'currentDirectory' => $currentDirectory,
            'files' => $files,
            'subdirectories' => $subdirectories,
        ]);
    }

    public function add()
    {
        $this->view('files/add');
    }

    public function store(): void
    {
        $file = $this->request()->file('file');

        $validation = $this->request()->validate([
            'title' => ['required', 'max:255', 'min:3'],
            'file' => ['required', 'file', 'size:500000024'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/files/add');
        }

        $filePath = $file->move('files');
//        $this->db()->insert('files', [
//            'user_id' => $this->session()->get('user_id'),
//            'directory_id' => '',
//            'file_name' => $this->request()->input('title'),
//            'file_path' => $filePath,
//        ]);

        $this->redirect('/files/list');
    }

}
