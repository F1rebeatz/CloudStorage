<?php

namespace App\Models;

class UserModel
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private int    $id,
        private string $name,
        private string $email,
        private string $password
    )
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}
