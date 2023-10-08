<?php

namespace App\Controllers;

use App\Models\DirectoryModel;
use App\Services\DirectoryService;
use App\Services\FileService;
use Kernel\Controller\Controller;
use Kernel\Database\DatabaseInterface;

class FilesController extends Controller
{
    public function index(): void
    {
        $user = $this->session()->get('user_id');
        $currentDirectory = $this->getIdCurrentDirectory($user);

        $files = $this->getFiles($currentDirectory);
        $subdirectories = $this->getDirectories($currentDirectory);

        $this->view('files/list', [
            'files' => $files,
            'subdirectories' => $subdirectories,
            'directory' => $currentDirectory,
        ]);
    }

    public function add(): void
    {
        $user = $this->session()->get('user_id');
        $directoryId = $this->getIdCurrentDirectory($user);
        $subdirectories = $this->getDirectories($directoryId);

        $this->view('files/add', [
            'subdirectories' => $subdirectories,
            'directoryId' => $directoryId,
        ]);
    }

    public function store(): void
    {
        $file = $this->request()->file('file');
        $title = $this->request()->input('title');
        $userId = $this->session()->get('user_id');

        $validation = $this->request()->validate([
            'title' => ['required', 'max:255', 'min:3'],
            'file' => ['required', 'file', 'size:500000024'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/files/add');
            return;
        }

        $directoryId = $this->request()->query('directory') ?? $this->getRootDirectoryId($userId);

        $filePath = $file->move('files');

        $fileData = [
            'user_id' => $userId,
            'directory_id' => $directoryId,
            'file_name' => $title,
            'file_path' => $filePath,
        ];

        if (FileService::createFile($this->db(), $fileData)) {
            $this->redirect('/files/list');
        } else {
            $this->view('error', [
                'message' => 'Error creating file',
            ]);
        }
    }

    private function getDirectories(?int $directoryId): array
    {
        return DirectoryService::getSubdirectories($this->db(), $directoryId);
    }

    private function getFiles(?int $directoryId): array
    {
        return FileService::getFilesInDirectory($this->db(), $directoryId);
    }

    private function getIdCurrentDirectory(int $user): ?int
    {
        $directoryId = $this->request()->query('directory');

        return $directoryId === null ? $this->getRootDirectoryId($user) : intval($directoryId);
    }

    private function getRootDirectoryId(int $user): ?int
    {
        return DirectoryService::rootDirectory($this->db(), $user);
    }
}

