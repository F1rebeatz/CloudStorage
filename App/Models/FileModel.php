<?php

namespace App\Models;

class FileModel
{
    public function __construct(
        private int    $id,
        private int    $user_id,
        private ?int   $directory_id,
        private string $filename,
        private string $filepath,
        private string $created_at,
        private string $updated_at
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

    public function getDirectoryId(): ?int
    {
        return $this->directory_id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFilepath(): string
    {
        return $this->filepath;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getExtension(): string
    {
        $filenameParts = explode('.', $this->filepath);
        return end($filenameParts);
    }
}
