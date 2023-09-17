<?php

use apllication\Controllers\UserController;
use apllication\Models\UserModel;

require_once "session.php";
require_once "vendor/autoload.php";
include 'App/Views/template_view.php';
include 'database.php';

$userModel = new UserModel(getPDO());
$userController = new UserController($userModel);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $fullname = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["confirm_password"]);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $userData = [
        'name' => $fullname,
        'email' => $email,
        'password' => $password_hash,
    ];

    $registrationResult = $userController->register($userData);

    if ($registrationResult === true) {
        header("Location: welcome.php");
        exit;
    } else {
        $error = '<p class="error">' . $registrationResult . '</p>';
    }

    if ($registrationResult === true) {
        session_start();
        $_SESSION["userid"] = true;
        $_SESSION["name"] = $fullname;

        header("Location: welcome.php");
        exit;
    }
}

$content = include 'register_view.php';
include 'template_view.php';

