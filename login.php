<?php

use apllication\Controllers\UserController;
use apllication\Models\UserModel;

require_once "session.php";
$config = include('config.php');
require_once "database.php";

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $error .= '<p class="error">Please enter email.</p>';
    }

    if (empty($password)) {
        $error .= '<p class="error">Please enter your password.</p>';
    }

    if (empty($error)) {
        $userModel = new UserModel(getPDO());
        $userController = new UserController($userModel);

        $userData = [
            'email' => $email,
            'password' => $password
        ];

        $authResult = $userController->login($userData);

        if ($authResult === true) {
            header("location: welcome.php");
            exit;
        } else {
            $error .= '<p class="error">' . $authResult . '</p>';
        }
    }
}

$content = include("login_view.php");
include("template_view.php");





