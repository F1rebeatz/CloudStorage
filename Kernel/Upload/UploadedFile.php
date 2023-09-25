<?php

namespace Kernel\Upload;

class UploadedFile implements UploadedFileInterface
{

    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $tmpName,
        public readonly string $error,
        public readonly string $size,
    ) {

    }
    public function move(string $path):string|false
    {
        // TODO: Implement move() method.
    }
}