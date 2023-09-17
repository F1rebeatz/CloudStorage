<?php

namespace App\Controllers;

use App\Models\UserModel;


class UserController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function list(): array
    {
        $users = $this->userModel->all(['id', 'email', 'age', 'gender']);
        return json_encode($users);
    }

    public function get($id): string
    {
        $user = $this->userModel->find($id);
        if ($user) {
            return json_encode($user);
        } else {
            return json_encode(['error' => 'User not found']);
        }
    }

    public function update()
    {

    }

    public function register(array $userData): bool
    {
        $errors = [];

        if (empty($userData['name'])) {
            $errors['name'] = 'Full Name is required.';
        }

        if (empty($userData['email'])) {
            $errors['email'] = 'Email is required.';
        } elseif (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        } elseif ($this->userModel->userExists($userData['email'])) {
            $errors['email'] = 'Email is already taken.';
        }

        if (empty($userData['password'])) {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            $content = include 'register_view.php';
            include 'template_view.php';
            exit;
        }

        $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);

        $userData['password'] = $hashedPassword;
        $userData['role'] = 'user';
        $userData['age'] = 0;
        $userData['gender'] = '';

        $this->userModel->create($userData);

        session_start();
        $_SESSION["userid"] = true;
        $_SESSION["name"] = $userData['name'];
        header("Location: welcome.php");
        exit;

        $content = include 'register_view.php';
        include 'template_view.php';
    }

    public function login(array $userData): bool
    {

    }

    public function logout()
    {

    }

    public function reset_password()
    {

    }
}