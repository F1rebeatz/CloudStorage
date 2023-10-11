<?php

namespace App\Controllers;

use App\Services\DirectoryService;
use Kernel\Controller\Controller;

class DirectoryController extends Controller
{

  public function add() {
    $this->view('directories/add');
  }


    public function create() {
        $directoryName = $this->request()->input('directory_name');
        $currenDirectory =
        $createdDirectory = DirectoryService::createDirectory($this->db(), ['directory_name' => $directoryName]);

        if ($createdDirectory) {
            $this->redirect("/directories/get?directory={$createdDirectory}");
        } else {
             $this->redirect('/files/list');
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