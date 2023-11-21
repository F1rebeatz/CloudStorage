<?php

namespace Kernel\Storage;

interface StorageInterface
{
    public function url(string $path):string;
    public function get(string $path):string;
    public function storagePath(string $path):string;
}