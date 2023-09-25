<?php

namespace App\Kernel\Upload;

interface UploadedFileInterface
{
    public function move(string $path):string|false;
}