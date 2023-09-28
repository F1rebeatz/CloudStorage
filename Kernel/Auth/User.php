<?php

namespace Kernel\Auth;

class User
{
    public function __construct(
        private int $id,
        private string $email,
        private string $password,
        private string $name
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
}