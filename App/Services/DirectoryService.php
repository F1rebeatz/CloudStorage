<?php

namespace App\Services;

use App\Models\DirectoryModel;
use Exception;
use Kernel\Database\DatabaseInterface;

class DirectoryService
{
    private DatabaseInterface $db;
    public function __construct()
    {
    }
    public function setDatabase(DatabaseInterface $db):void {
        $this->db = $db;
    }

    public function createDirectory(array $data): ?DirectoryModel
    {
        try {
            $directoryId = $this->db->insert('directories', $data);

            return $directoryId ? $this->findDirectory($directoryId) : null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function findDirectory(int $id, int $currentUserId): ?DirectoryModel
    {
        if ($id === 0) {
            return new DirectoryModel(
                id: 0,
                user_id: $currentUserId,
                parent_directory_id: null,
                directory_name: 'Root'
            );
        }

        try {
            $directoryData = $this->db->first('directories', ['id' => $id, 'user_id' => $currentUserId]);

            if (!$directoryData) {
                return null;
            }

            return new DirectoryModel(
                id: $directoryData['id'],
                user_id: $directoryData['user_id'],
                parent_directory_id: $directoryData['parent_directory_id'],
                directory_name: $directoryData['directory_name']
            );
        } catch (Exception $e) {
            return null;
        }
    }


    public function updateDirectory(int $directoryId, array $data): ?DirectoryModel
    {
        try {
            $this->db->update('directories', $directoryId, $data);
            return $this->findDirectory($directoryId);
        } catch (Exception $e) {
            return null;
        }
    }

    public function deleteDirectory(int $directoryId): bool
    {
        try {
            $this->db->delete('directories', ['id' => $directoryId]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param int $parentDirectoryId
     * @return array<DirectoryModel>
     */
    public function getSubdirectories(int $parentDirectoryId): array
    {
        $conditions = ['parent_directory_id' => $parentDirectoryId];
        $subdirectories = $this->db->get('directories', $conditions);

        return array_map(function ($directory) {
            return new DirectoryModel(
                id: $directory['id'],
                user_id: $directory['user_id'],
                parent_directory_id: $directory['parent_directory_id'],
                directory_name: $directory['directory_name']
            );
        }, $subdirectories);
    }
}

