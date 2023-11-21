<?php

namespace App\Services;

use App\Models\DirectoryModel;
use Exception;
use Kernel\Database\Database;
use Kernel\Database\DatabaseInterface;

class DirectoryService
{

    /**
     * @param DatabaseInterface $db
     * @param array $data
     * @return int|null
     */
    public static function createDirectory(DatabaseInterface $db, array $data): ?int
    {
        try {
            return $db->insert('directories', $data);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param DatabaseInterface $db
     * @param int $id
     * @return DirectoryModel|null
     */
    public static function findDirectory(DatabaseInterface $db, int $id): ?DirectoryModel
    {
        $directory = $db->first('directories', ['id' => $id]);
        if ($directory) {
            return new DirectoryModel(
                id: $directory['id'],
                user_id: $directory['user_id'],
                parent_directory_id: $directory['parent_directory_id'],
                directory_name: $directory['directory_name']
            );
        }

        return null;
    }


    /**
     * @param DatabaseInterface $db
     * @param int $directoryId
     * @param array $data
     * @return DirectoryModel|null
     */
    public static function updateDirectory(DatabaseInterface $db, int $directoryId, array $data): ?DirectoryModel
    {
        try {
            $db->update('directories', $data, ['id' => $directoryId]);
            $directory = $db->first('directories', ['id' => $directoryId]);
            return new DirectoryModel(
                id: $directory['id'],
                user_id: $directory['user_id'],
                parent_directory_id: $directory['parent_directory_id'],
                directory_name: $directory['directory_name']
            );
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param DatabaseInterface $db
     * @param int $directoryId
     * @return bool
     */
    public static function deleteDirectory(DatabaseInterface $db, int $directoryId): bool
    {
        try {
            $directory = DirectoryService::findDirectory($db, $directoryId);
            if (!$directory) {
                return false;
            }

            $filesInDirectory = FileService::getFilesInDirectory($db, $directoryId);

            foreach ($filesInDirectory as $file) {
                FileService::deleteFile($db, $file->getId());
            }

            $db->delete('directories', ['id' => $directoryId]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * @param int $parentDirectoryId
     * @return array<DirectoryModel>
     */
    public static function getSubdirectories(DatabaseInterface $db, ?int $parentDirectoryId): array
    {
        if ($parentDirectoryId === null) {
            return [];
        }

        $conditions = ['parent_directory_id' => $parentDirectoryId];
        $subdirectories = $db->get('directories', $conditions);

        return array_map(function ($directory) {
            return new DirectoryModel(
                id: $directory['id'],
                user_id: $directory['user_id'],
                parent_directory_id: $directory['parent_directory_id'],
                directory_name: $directory['directory_name']
            );
        }, $subdirectories);
    }


    /**
     * @param DatabaseInterface $db
     * @param int $userId
     * @return int|null
     */
    public static function rootDirectory(DatabaseInterface $db, int $userId): ?int
    {
        $directory = $db->first('directories', ['user_id' => $userId, 'parent_directory_id' => null]);
        return $directory ? $directory['id'] : null;
    }

    /**
     * @param DatabaseInterface $db
     * @param int $userId
     * @return array
     */
    public static function getUsersDirectories(DatabaseInterface $db, int $userId): array {
        $directories = $db->get('directories', ['user_id' => $userId]);
        return array_map(function ($directory) {
            return new DirectoryModel(
                id: $directory['id'],
                user_id: $directory['user_id'],
                parent_directory_id: $directory['parent_directory_id'],
                directory_name: $directory['directory_name']
            );
        }, $directories);
    }
}
