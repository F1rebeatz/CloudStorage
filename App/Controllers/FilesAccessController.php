<?php

namespace App\Controllers;

use App\Services\DirectoryService;
use App\Services\FileAccessService;
use App\Services\FileService;
use App\Services\UserService;
use Kernel\Controller\Controller;

class FilesAccessController extends Controller
{
    /**
     * @param int $id The file ID.
     * @return void
     */
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

    /**
     * @param int $id The file ID.
     * @return void
     */
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

    /**
     * @param string $errorMessage The error message.
     * @param int $id The file ID.
     * @return void
     */
    private function handleError(string $errorMessage, int $id): void
    {
        $this->session()->set('error', $errorMessage);
        $this->redirect("/files/share/{$id}");
    }

    /**
     * @param string $successMessage The success message.
     * @param int $id The file ID.
     * @return void
     */
    private function handleSuccess(string $successMessage, int $id): void
    {
        $this->session()->set('success', $successMessage);
        $this->redirect("/files/share/{$id}");
    }

    /**
     * @param int $id The file ID.
     * @param int $user_id The user ID to remove from sharing.
     * @return void
     */
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
