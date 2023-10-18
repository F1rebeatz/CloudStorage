<?php

namespace App\Controllers;

use App\Services\DirectoryService;
use App\Services\FileAccessService;
use App\Services\FileService;
use App\Services\UserService;
use Kernel\Controller\Controller;

class FilesAccessController extends Controller
{
    public function getSharedUsers(int $id): void
    {
        $file = FileService::findFile($this->db(), $id);

        if (!$file) {
            $this->session()->set('error', 'File not found');
            $this->redirect('/directory/get/' . $this->session()->get('directory_id'));
            return;
        }

        $usersWithAccess = FileAccessService::getUsersWithAccess($this->db(), $id);

        $this->view('files/share', [
            'file' => $file,
            'usersWithAccess' => $usersWithAccess,
        ]);
    }

    public function addSharedUser(int $id): void
    {
        $file = FileService::findFile($this->db(), $id);

        if (!$file) {
            $this->handleError('File not found', $id);
            return;
        }

        $userEmail = $this->request()->input('recipientEmail');
        $user = UserService::getUserByEmail($this->db(), $userEmail);

        if (!$user) {
            $this->handleError('User with this email not found', $id);
            return;
        }

        $rootDirectory = DirectoryService::rootDirectory($this->db(), $user->getId());

        $dataAssets = [
            'file_id' => $id,
            'user_id' => $user->getId(),
        ];

        $newDataFile = [
            'user_id' => $user->getId(),
            'directory_id' => $rootDirectory,
            'file_name' => $file->getFilename(),
            'file_path' => $file->getFilePath(),
        ];

        $resultAssets = FileAccessService::addSharedUser($this->db(), $dataAssets);
        $result = FileService::createFile($this->db(), $newDataFile);

        if ($result && $resultAssets) {
            $this->handleSuccess('Access granted successfully', $id);
        } else {
            $this->handleError('Failed to grant access', $id);
        }
    }


    private function handleError(string $errorMessage, int $id): void
    {
        $this->session()->set('error', $errorMessage);
        $this->redirect("/files/share/{$id}");
    }

    private function handleSuccess(string $successMessage, int $id): void
    {
        $this->session()->set('success', $successMessage);
        $this->redirect("/files/share/{$id}");
    }

    public function removeSharedUser(int $id, int $user_id): void
    {
        $file = FileService::findFile($this->db(), $id);

        $data = ['user_id' => $user_id, 'file_path' => $file->getFilepath()];
        $sharedFile = FileService::findSharedFile($this->db(), $data);

        FileAccessService::removeSharedUser($this->db(), $id, $user_id);
        FileService::deleteFile($this->db(), $sharedFile->getId());
        $this->redirect("/files/share/{$id}");
    }
}