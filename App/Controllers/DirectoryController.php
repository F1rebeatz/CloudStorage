<?php

namespace App\Controllers;

use App\Services\DirectoryService;
use App\Services\FileService;
use Kernel\Controller\Controller;

class DirectoryController extends Controller
{
    public function index($id)
    {
        $directory = DirectoryService::findDirectory($this->db(), $id);
        $subdirectories = DirectoryService::getSubdirectories($this->db(), $id);
        $files = FileService::getFilesInDirectory($this->db(), $id);

        if ($directory) {
            $this->view('/directories/get', ['directory' => $directory, 'files' => $files, 'subdirectories' => $subdirectories]);
        } else {
            $this->redirect("files/list");
        }
    }

    public function add()
    {
        $directory = intval($this->request()->query('directory'));
        $this->view('directories/add', ['directory' => $directory]);
    }


    public function create()
    {
        $directoryName = $this->request()->input('directory_name');
        $currentDirectory = intval($this->request()->input('directory'));
        $user = $this->session()->get('user_id');
        $createdDirectory = DirectoryService::createDirectory($this->db(), ['directory_name' => $directoryName,
            'parent_directory_id' => $currentDirectory, 'user_id' => $user]);

        if ($createdDirectory) {
            $this->redirect('/files/list');
        } else {
            $this->redirect('/files/list');
        }
    }

    public function edit(int $id) : void {
        $directory = DirectoryService::findDirectory($this->db(), $id);

        if (!$directory) {
            $this->redirect('/files/list');
            return;
        }

        $this->view('directories/edit', ['directory' => $directory]);
    }

    public function update($id): void
    {
        $newDirectoryName = $this->request()->input('name');
        $updatedDirectory = DirectoryService::updateDirectory($this->db(), $id, ['directory_name' => $newDirectoryName]);

        if ($updatedDirectory) {
            $this->session()->set('success', 'Directory updated successfully.');
        } else {
            $this->session()->set('error', 'Directory update failed.');
        }

        $this->redirect("/directories/get/{$id}");
    }



    public function delete(int $id): void
    {
        $directory = DirectoryService::findDirectory($this->db(), $id);

        if ($directory) {
            $filesInDirectory = FileService::getFilesInDirectory($this->db(), $id);
            foreach ($filesInDirectory as $file) {
                FileService::deleteFile($this->db(), $file->getId());
            }
            if (DirectoryService::deleteDirectory($this->db(), $id)) {
                $this->session()->set('success', 'Directory and its files deleted successfully.');
            } else {
                $this->session()->set('error', 'Failed to delete directory.');
            }
        } else {
            $this->session()->set('error', 'Directory not found.');
        }
        $this->redirect('/files/list');
    }

}