<?php

namespace App\Services;

use App\Models\UserModel;
use Exception;
use Kernel\Database\DatabaseInterface;

class UserService
{
    /**
     * @param DatabaseInterface $db
     * @return array
     */
    public static function getAllUsers(DatabaseInterface $db): array
    {

        $usersData = $db->get('users', []);
        return array_map(fn($user) => new UserModel(
            id: $user['id'],
            name: $user['name'],
            email: $user['email'],
            password: $user['password']
        ), $usersData);
    }

    /**
     * @param DatabaseInterface $db
     * @param $id
     * @return UserModel|null
     */
    public static function getUserById(DatabaseInterface $db, $id): ?UserModel
    {
        $userData = $db->first('users', ['id' => $id]);
        if ($userData) {
            return new UserModel(
                id: $userData['id'],
                name: $userData['name'],
                email: $userData['email'],
                password: $userData['password']
            );
        }

        return null;
    }

    /**
     * @param DatabaseInterface $db
     * @param array $data
     * @param array $conditions
     * @return bool
     */
    public static function updateUser(DatabaseInterface $db, array $data, array $conditions): bool
    {
        if ($db->update('users', $data, $conditions)) {
            return true;
        }
        return false;
    }


    /**
     * @param DatabaseInterface $db
     * @param int $id
     * @return bool
     */
    public static function deleteUser(DatabaseInterface $db, int $id): bool
    {
        try {
            $user = self::getUserById($db, $id);

            if (!$user) {
                return false;
            }

            $directories = DirectoryService::getUsersDirectories($db, $user->getId());

            foreach ($directories as $directory) {
                DirectoryService::deleteDirectory($db, $directory->getId());
            }

            $db->delete('users', ['id' => $id]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param DatabaseInterface $db
     * @param string $userEmail
     * @return UserModel|null
     */
    public static function getUserByEmail(DatabaseInterface $db, string $userEmail): ?UserModel
    {
        $user = $db->first('users', ['email' => $userEmail]);
        if ($user) {
            return new UserModel(
                id: $user['id'],
                name: $user['name'],
                email: $user['email'],
                password: $user['password']
            );
        }
    }

}
