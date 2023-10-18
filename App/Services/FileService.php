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
     * @param DatabaseInterface $db
     * @param int|null $directoryId
     * @return array
     */
    public static function getFilesInDirectory(DatabaseInterface $db, ?int $directoryId): array
    {
        if ($directoryId === null) {
            return [];
        }

        $conditions = ['directory_id' => $directoryId];
        $files = $db->get('files', $conditions);

        return array_map(function ($file) {
            return new FileModel(
                id: $file['id'],
                user_id: $file['user_id'],
                directory_id: $file['directory_id'],
                filename: $file['file_name'],
                filepath: $file['file_path'],
                created_at: $file['created_at'],
                updated_at: $file['updated_at']
            );
        }, $files);
    }

    /**
     * @param DatabaseInterface $db
     * @param array $data
     * @return bool
     */
    public static function createFile(DatabaseInterface $db, array $data): bool
    {
        try {
            return $db->insert('files', $data);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param DatabaseInterface $db
     * @param array $data
     * @param array $conditions
     * @return bool
     */
    public static function updateFile(DatabaseInterface $db, array $data, array $conditions): bool
    {
        try {
            $db->update('files', $data, $conditions);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param DatabaseInterface $db
     * @param int $fileId
     * @return bool
     */
    public static function deleteFile(DatabaseInterface $db, int $fileId): bool
    {
        try {
            $file = $db->first('files', ['id' => $fileId]);

            if (!$file) {
                return false;
            }

            $fileModel = new FileModel(
                id: $file['id'],
                user_id: $file['user_id'],
                directory_id: $file['directory_id'],
                filename: $file['file_name'],
                filepath: $file['file_path'],
                created_at: $file['created_at'],
                updated_at: $file['updated_at']
            );

            $storage = new Storage(new Config());
            $filePath = $fileModel->getFilepath();
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

    /**
     * @param DatabaseInterface $db
     * @param int $fileId
     * @return FileModel|null
     */
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
            filepath: $file['file_path'],
            created_at: $file['created_at'],
            updated_at: $file['updated_at']
        );
    }

    /**
     * @param DatabaseInterface $db
     * @param array $data
     * @return FileModel|null
     */
    public static function findSharedFile(DatabaseInterface $db, array $data): ?FileModel {
        $file = $db->first('files', $data);
        if (!$file) {
            return null;
        }

        return new FileModel(
            id: $file['id'],
            user_id: $file['user_id'],
            directory_id: $file['directory_id'],
            filename: $file['file_name'],
            filepath: $file['file_path'],
            created_at: $file['created_at'],
            updated_at: $file['updated_at']
        );
    }
}
