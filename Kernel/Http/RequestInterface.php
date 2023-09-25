<?php

namespace Kernel\Http;

use Kernel\Upload\UploadedFileInterface;
use Kernel\Validator\ValidatorInterface;

interface RequestInterface
{
    public static function createFromGlobals(): static;

    public function uri(): string;

    public function method(): string;

    public function input($key, $default = null): mixed;
    public function file(string $key): ?UploadedFileInterface;
    public function setValidator(ValidatorInterface $validator): void;

    public function validate(array $rules): bool;

    public function errors(): array;
}