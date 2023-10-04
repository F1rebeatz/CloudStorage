<?php

namespace App\Models;

class FileModel
{
    public function __construct(
        private int    $id,
        private string $user_id,
        private string $directory_id,
        private string $filename,
        private string $filepath,
    )
    {

    }
    public function id(): int {
        return $this->id;
    }
    public function user_id(): string {
        return $this->user_id;
    }
    public function directory_id(): string {
        return $this->directory_id;
    }
    public function filename(): string {
        return $this->filename;
    }
    public function filepath(): string {
        return $this->filepath;
    }
}