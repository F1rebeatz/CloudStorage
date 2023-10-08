<?php

namespace App\Services;

use App\Models\FileModel;
use Exception;
use Kernel\Database\DatabaseInterface;

class FileService
{

    /**
     * @param int $directoryInt
     * @return array<FileModel>
     */
    public static function getFilesInDirectory(DatabaseInterface $db, ?int $directoryInt): array
    {
        if ($directoryInt === null) {
            return [];
        }

        $conditions = ['directory_id' => $directoryInt];
        $files = $db->get('files', $conditions);

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


    public static function createFile(DatabaseInterface $db, $data): bool
    {
        try {
            return $db->insert('files', $data);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function updateFile(DatabaseInterface $db, int $fileId, array $data): bool
    {
        try {
            $db->update('files', $fileId, $data);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteFile(DatabaseInterface $db, int $fileId): bool
    {
        try {
            $db->delete('files', ['id' => $fileId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function findFile(DatabaseInterface $db, int $fileId): ?FileModel
    {
        $file = $db->first('files', ['id' => $fileId]);

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

