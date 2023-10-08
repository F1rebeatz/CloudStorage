<?php

namespace App\Models;

class DirectoryModel
{
    public function __construct(
        private int $id,
        private int $user_id,
        private ?int $parent_directory_id,
        private string $directory_name
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getParentDirectoryId(): ?int
    {
        return $this->parent_directory_id;
    }

    public function getDirectoryName(): string
    {
        return $this->directory_name;
    }
}
