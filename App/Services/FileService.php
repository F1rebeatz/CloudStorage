<?php

namespace App\Services;

use App\Models\FileModel;
use Exception;
use Kernel\Database\DatabaseInterface;

class FileService
{
    private DatabaseInterface $db;

    public function __construct()
    {
    }

    public function setDatabase(DatabaseInterface $db):void {
        $this->db = $db;
    }

    /**
     * @param int $directoryInt
     * @return array<FileModel>
     */
    public function getFilesInDirectory(int $directoryInt): array
    {
        $conditions = ['directory_id' => $directoryInt];
        $files = $this->db->get('files', $conditions);

        return array_map(function ($file) {
            return new FileModel(
                id: $file['id'],
                user_id: $file['user_id'],
                directory_id: $file['directory_id'],
                filename: $file['file_name'],
                filepath: $file['file_path']
            );
        }, $files);
    }

    public function createFile(array $data): bool
    {
        try {
            return $this->db->insert('files', $data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateFile(int $fileId, array $data): bool
    {
        try {
            $this->db->update('files', $fileId, $data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteFile(int $fileId): bool
    {
        try {
            $this->db->delete('files', ['id' => $fileId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function findFile(int $fileId): ?FileModel
    {
        $file = $this->db->first('files', ['id' => $fileId]);

        if (!$file) {
            return null;
        }

        return new FileModel(
            id: $file['id'],
            user_id: $file['user_id'],
            directory_id: $file['directory_id'],
            filename: $file['file_name'],
            filepath: $file['file_path']
        );
    }
}

