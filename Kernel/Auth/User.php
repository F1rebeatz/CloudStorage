<?php

namespace Kernel\Auth;

class User
{
    public function __construct(
        private int $id,
        private string $email,
        private string $password,
        private string $name,
        private string $role
    ) {

    }
    public function id():int {
        return $this->id;
    }

    public function email():string {
        return $this->email;
    }

    public function password():string {
        return $this->password;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    public function role(): int {
        return intval($this->role);
    }
}