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

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->user_id;
    }

    public function parentDirectoryId(): ?int
    {
        return $this->parent_directory_id;
    }

    public function directoryName(): string
    {
        return $this->directory_name;
    }
}
