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
        $currentDirectoryId = $this->getIdCurrentDirectory($user);
        $files = $this->getFiles($currentDirectoryId);

        $subdirectories = $this->getDirectories($currentDirectoryId);

        $this->view('files/list', [
            'files' => $files,
            'subdirectories' => $subdirectories,
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
            $this->session()->set('success', 'File added successfully.');
            $this->redirect('/files/list');
        } else {
            $this->session()->set('error', 'File add failed.');
        }
    }

    public function download(): void
    {
        $fileId = $this->request()->query('file');

        $file = FileService::findFile($this->db(), $fileId);

        if ($file) {
            $filePath = $this->storage()->storagePath($file->getFilePath());

            if (file_exists($filePath)) {
                $extention = pathinfo($filePath, PATHINFO_EXTENSION);
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file->getFilename() . ".$extention") . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));

                readfile($filePath);
                exit;
            } else {

                $this->session()->set('error', 'File not found');
                $this->redirect('/files/list');
            }
        } else {

            $this->session()->set('error', 'File not found');
            $this->redirect('/files/list');
        }
    }

    public function delete(): void
    {
        $fileId = $this->request()->query('file');
        if (FileService::deleteFile($this->db(), $fileId)) {
            $this->redirect('/files/list');
        }
    }

    public function edit(): void
    {
        $fileId = $this->request()->query('file');
        $file = FileService::findFile($this->db(), $fileId);
        $user = $this->session()->get('user_id');
        if (!$file) {
            $this->redirect('/files/list');
            return;
        }
        $currentDirectoryId = $file->getDirectoryId();

        $subdirectories = $this->getDirectories($currentDirectoryId);
        $this->view('files/edit', ['file' => $file, 'subdirectories' => $subdirectories, 'directoryId' => $currentDirectoryId]);
    }


    public function update(): void
    {
        $fileId = $this->request()->input('fileId');
        $file = FileService::findFile($this->db(), $fileId);
        $user = $this->session()->get('user_id');

        if (!$file) {
            $this->redirect('/files/list');
            return;
        }

        $newTitle = $this->request()->input('title');
        $newDirectoryId = intval($this->request()->input('directory'));

        $validation = $this->request()->validate([
            'title' => ['required', 'max:255', 'min:3'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/files/edit');
            return;
        }

        $success = FileService::updateFile($this->db(), [
            'user_id' => $user,
            'directory_id' => $newDirectoryId,
            'file_name' => $newTitle,
        ], ['id' => $fileId]);

        if ($success) {
            $this->session()->set('success', 'File updated successfully.');
        } else {
            $this->session()->set('error', 'File update failed.');
        }

        $this->redirect('/files/list');
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

