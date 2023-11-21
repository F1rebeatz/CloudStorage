<?php

namespace Kernel\Auth;

interface AuthInterface
{
    public function attempt($username, $password):bool;
    public function logout():void;
    public function check():bool;
    public function user(): ?User;

    public function username():string;
    public function password():string;
    public function table():string;
    public function session_field():string;

}