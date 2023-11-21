<?php

namespace Kernel\Database;

use Kernel\Config\ConfigInterface;
use PDO;

class Database implements DatabaseInterface
{
    private \PDO $pdo;

    public function __construct(
        private ConfigInterface $config
    )
    {
        $this->connect();
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function insert(string $table, array $data): int|false
    {
        $fields = array_keys($data);

        $columns = implode(', ', $fields);
        $binds = implode(', ', array_map(fn($field) => ":$field", $fields));

        $sql = "INSERT INTO $table ($columns) VALUES ($binds)";

        $stmn = $this->pdo->prepare($sql);
        try {
            $stmn->execute($data);

        } catch (\PDOException $exception) {
            dd($exception);
            return false;
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function first(string $table, array $conditions = []): ?array
    {
        $where = '';
        $params = [];

        foreach ($conditions as $field => $value) {
            if ($value === null) {
                $whereConditions[] = "$field IS NULL";
            } else {
                $whereConditions[] = "$field = :$field";
                $params[":$field"] = $value;
            }
        }

        if (!empty($whereConditions)) {
            $where = 'WHERE ' . implode(' AND ', $whereConditions);
        }

        $sql = "SELECT * FROM $table $where LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }




    private function connect()
    {
        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $database = $this->config->get('database.database');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $charset = $this->config->get('database.charset');

        try {
            $this->pdo = new \PDO(
                "$driver:host=$host;port=$port;dbname=$database;charset=$charset",
                $username,
                $password
            );
        } catch (\PDOException $exception) {
            exit("Database connection failed: {$exception->getMessage()}");
        }
    }

    public function get(string $table, array $conditions = []): array
    {
        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "SELECT * FROM $table $where";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(($conditions));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(string $table, array $conditions = []): void
    {
        $where = '';
        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', array_map(fn($field) => "$field = :$field", array_keys($conditions)));
        }
        $sql = "DELETE FROM $table $where";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);
    }

    public function update(string $table, array $data, array $conditions = []): bool
    {
        $fields = array_keys($data);

        $set = implode(', ', array_map(fn ($field) => "$field = :$field", $fields));

        $where = '';

        if (count($conditions) > 0) {
            $where = 'WHERE '.implode(' AND ', array_map(fn ($field) => "$field = :$field", array_keys($conditions)));
        }

        $sql = "UPDATE $table SET $set $where";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(array_merge($data, $conditions));
    }
}