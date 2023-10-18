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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int|null
     */
    public function getDirectoryId(): ?int
    {
        return $this->directory_id;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        $filenameParts = explode('.', $this->filepath);
        return end($filenameParts);
    }
}
