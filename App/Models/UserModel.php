<?php

namespace App\Models;
class UserModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(array $fields = ['*']): array
    {
        $fieldStr = implode(',', $fields);
        $stmt = $this->pdo->prepare("SELECT $fieldStr FROM user");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $userData): void
    {
        $query = "INSERT INTO user (email, password, role, age, gender) VALUES (:email, :password,:role, :age, :gender)";
        $stmt = $this->pdo->prepare("$query");
        $stmt->execute([
            ":email" => $userData['email'],
            ':password' => $userData['password'],
            ':role' => $userData['role'],
            ':age' => $userData['age'],
            ':gender' => $userData['gender'],
        ]);
    }

    public function userExists(string $email): bool
    {
        $query = "SELECT COUNT(*) FROM user WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);

        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function find($id): ?array
    {
        $query = "SELECT * FROM user WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":id" => $id]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?? null;
    }

    public function destroy($id): void
    {
        $query = "DELETE FROM user WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":id" => $id]);
    }
}