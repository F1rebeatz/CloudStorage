<?php

namespace App\Services;

use App\Models\UserModel;
use Kernel\Database\DatabaseInterface;

class FileAccessService
{
    public static function getUsersWithAccess(DatabaseInterface $db, int $id): array
    {
        return array_map(function ($fileShare) use ($db) {
            $userId = $fileShare['user_id'];
            $user = $db->first('users', ['id' => $userId]);

            return $user ? new UserModel(
                id: $user['id'],
                name: $user['name'],
                email: $user['email'],
                password: $user['password']
            ) : null;
        }, $db->get('file_shares', ['file_id' => $id]));
    }

    public static function addSharedUser(DatabaseInterface $db, array $data): bool
    {
        return $db->insert('file_shares', $data);
    }

    public static function removeSharedUser(DatabaseInterface $db, int $id, int $user_id): void
    {
         $db->delete('file_shares', ['file_id' => $id, 'user_id' => $user_id]);
    }
}