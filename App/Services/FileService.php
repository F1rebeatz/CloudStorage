<?php

namespace App\Services;

use App\Models\FileModel;
use Exception;
use Kernel\Config\Config;
use Kernel\Database\DatabaseInterface;
use Kernel\Storage\Storage;

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

    public static function updateFile(DatabaseInterface $db, array $data, array $conditions): bool
    {
        try {
            $db->update('files', $data, $conditions);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteFile(DatabaseInterface $db, int $fileId): bool
    {
        try {

            $file = $db->first('files', ['id' => $fileId]);

            if (!$file) {
                return false;
            }
            $file = new FileModel(
                id: $file['id'],
                user_id: $file['user_id'],
                directory_id: $file['directory_id'],
                filename: $file['file_name'],
                filepath: $file['file_path']
            );

            $storage = new Storage(new Config());
            $filePath = $file->getFilepath();
            $fullFilePath = $storage->storagePath($filePath);

            if (file_exists($fullFilePath) && unlink($fullFilePath)) {
                $db->delete('files', ['id' => $fileId]);
                return true;
            }

            return false;
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

