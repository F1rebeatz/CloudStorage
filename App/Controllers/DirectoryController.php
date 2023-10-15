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
            $this->redirect("directories/get/{$id}");
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
            $this->redirect("/directories/get/{$createdDirectory}");
        } else {
            $this->redirect("/directories/get/{$currentDirectory}");
        }
    }

    public function edit(int $id) : void {
        $directory = DirectoryService::findDirectory($this->db(), $id);

        if (!$directory) {
            $this->redirect("directories/get/{$directory->getId()}");
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
            $parentDirectoryId = $directory->getParentDirectoryId();

            if (DirectoryService::deleteDirectory($this->db(), $id)) {
                $this->session()->set('success', 'Directory and its files deleted successfully.');
            } else {
                $this->session()->set('error', 'Failed to delete directory.');
            }

            if ($parentDirectoryId !== null) {
                $this->redirect('/directories/get/' . $parentDirectoryId);
            } else {
                $this->redirect('/home');
            }
        } else {
            $this->session()->set('error', 'Directory not found.');
            $this->redirect('/home');
        }
    }



}