<?php

namespace Kernel\Http;

use Kernel\Upload\UploadedFile;
use Kernel\Upload\UploadedFileInterface;
use Kernel\Validator\ValidatorInterface;

class Request implements RequestInterface
{
    private ValidatorInterface $validator;

    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server,
        public readonly array $files,
        public readonly array $cookies,
    )
    {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        $method = $this->input('_method');

        if (!empty($method) && in_array(strtoupper($method), ['PUT', 'DELETE'])) {
            return strtoupper($method);
        }

        return $this->server['REQUEST_METHOD'];
    }

    public function input($key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function query($key, $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function file(string $key): ?UploadedFileInterface
    {
        if (!isset($this->files[$key])) {
            return null;
        }
        return new UploadedFile(
            $this->files[$key]['name'],
            $this->files[$key]['type'],
            $this->files[$key]['tmp_name'],
            $this->files[$key]['error'],
            $this->files[$key]['size'],
        );
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function validate(array $rules): bool
    {
        $data = [];

        foreach ($rules as $field => $rule) {

            if ($this->hasFile($field)) {
                $data[$field] = $this->file($field);
                $data["{$field}_size"] = $this->file($field)->size();
            } else {
                $data[$field] = $this->input($field);
            }
        }

        return $this->validator->validate($data, $rules);

    }


    public function errors(): array
    {
        return $this->validator->errors();
    }

    private function hasFile(int|string $field): bool
    {
        return isset($this->files[$field]);
    }


}