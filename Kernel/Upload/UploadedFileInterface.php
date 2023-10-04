<?php

namespace Kernel\Upload;

interface UploadedFileInterface
{
    public function move(string $path, string $fileName = null):string|false;
    public function getExtension():string;

    public function size():string;

    public function error();
    public function name():string;
}