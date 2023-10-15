<?php

namespace App\Controllers;

use App\Models\DirectoryModel;
use App\Services\DirectoryService;
use App\Services\FileService;
use Kernel\Controller\Controller;
use Kernel\Database\DatabaseInterface;

class FilesController extends Controller
{
    public function add(): void
    {
        $user = $this->session()->get('user_id');
        $directoryId = $this->getIdCurrentDirectory($user);
        $directories = $this->getDirectories($directoryId);
        $this->view('files/add', [
            'directories' => $directories,
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
            $directoryId = $this->request()->input('directory');
            if ($directoryId) {
                $this->redirect('/directories/get/' . $directoryId);
            } else {
                $this->redirect('/files/add');
            }
            return;
        }

        $directoryId = intval($this->request()->input('directory', $this->getRootDirectoryId($userId)));
        $filePath = $file->move('files');

        $fileData = [
            'user_id' => $userId,
            'directory_id' => $directoryId,
            'file_name' => $title,
            'file_path' => $filePath,
        ];

        if (FileService::createFile($this->db(), $fileData)) {
            $this->session()->set('success', 'File added successfully');
            $directoryId = $this->request()->input('directory');
            if ($directoryId) {
                $this->redirect('/directories/get/' . $directoryId);
            } else {
                $this->redirect('/directories/get/' . $this->getRootDirectoryId($userId));
            }
        } else {
            $this->session()->set('error', 'File add failed');
            $this->redirect('/files/add');
        }
    }

    public function download(int $id): void
    {
        $file = FileService::findFile($this->db(), $id);

        if ($file) {
            $filePath = $this->storage()->storagePath($file->getFilePath());

            if (file_exists($filePath)) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file->getFilename() . ".$extension") . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));

                readfile($filePath);
                exit;
            } else {

                $this->session()->set('error', 'File not found');
                $this->redirect('/directories/get/' . $file->getDirectoryId());
            }
        } else {

            $this->session()->set('error', 'File not found');
            $this->redirect('/directories/get/' . $file->getDirectoryId());
        }
    }

    public function delete(int $id): void
    {
        $file = FileService::findFile($this->db(), $id);
        $directory = $file->getDirectoryId();
        if (FileService::deleteFile($this->db(), $id)) {
               $this->redirect('/directories/get/' . $directory);
        } else {
            $this->session()->set('error', 'File not removed');
            $this->redirect('/directories/get/' . $file->getDirectoryId());
        }
    }

    public function edit(int $id): void
    {
        $file = FileService::findFile($this->db(), $id);
        if (!$file) {
            $this->redirect('/directories/get/' . $this->session()->get('parent_directory_id'));
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
            $this->redirect('/directories/get/' . $this->getRootDirectoryId($user));
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
            $this->redirect('/files/edit/' . $fileId);
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
        $this->redirect('/directories/get/' . $newDirectoryId);
    }

    private function getDirectories(?int $directoryId): array
    {
        return DirectoryService::getSubdirectories($this->db(), $directoryId);
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

