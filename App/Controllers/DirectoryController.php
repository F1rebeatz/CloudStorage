<?php

namespace App\Controllers;

use Kernel\Controller\Controller;

class DirectoryController extends Controller
{
    private DirectoryService $directoryService;

    public function __construct(DirectoryService $directoryService)
    {
        $this->directoryService = $directoryService;
    }

    public function create() {
        $directoryName = $this->request()->input('name');
        $createdDirectory = $this->directoryService->createDirectory(['name' => $directoryName]);

        if ($createdDirectory) {
            $this->redirect("/directories/get{$createdDirectory}");
        } else {
             $this->redirect('/directories');
        }
    }
    public function read($directoryId) {
        $directory = $this->directoryService->find($directoryId);

        if ($directory) {
            $this->view('directories/list', ['directory' => $directory]);
        } else {

            $this->redirect("/directories/get{$directoryId}");
        }
    }

    public function update($directoryId) {
        $newDirectoryName = $this->request()->input('name');
        $updatedDirectory = $this->directoryService->updateDirectory($directoryId, ['name' => $newDirectoryName]);

        if ($updatedDirectory) {
            $this->redirect("/directories/get/{$directoryId}");
        } else {
            $this->redirect('/directories');
        }
    }

    public function delete($directoryId) {
        $result = $this->directoryService->deleteDirectory($directoryId);

        if ($result) {
            $this->redirect('/directories');
        } else {
            $this->redirect("/directories/get/{$directoryId}");
        }
    }
}