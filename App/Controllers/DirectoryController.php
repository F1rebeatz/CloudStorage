<?php

namespace App\Controllers;

use App\Services\DirectoryService;
use Kernel\Controller\Controller;

class DirectoryController extends Controller
{

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

    public function show($directoryId)
    {

        $directory = DirectoryService::findDirectory($this->db(), $directoryId);

        if ($directory) {
            $this->view('directories/show', ['directory' => $directory]);
        } else {

            $this->redirect("/directories/get{$directoryId}");
        }
    }

    public function update($directoryId)
    {
        $newDirectoryName = $this->request()->input('name');
        $updatedDirectory = $this->directoryService->updateDirectory($directoryId, ['name' => $newDirectoryName]);

        if ($updatedDirectory) {
            $this->redirect("/directories/get/{$directoryId}");
        } else {
            $this->redirect('/directories');
        }
    }

    public function delete($directoryId)
    {
        $result = $this->directoryService->deleteDirectory($directoryId);

        if ($result) {
            $this->redirect('/directories');
        } else {
            $this->redirect("/directories/get/{$directoryId}");
        }
    }
}