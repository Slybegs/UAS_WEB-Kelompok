<?php

use App\Models\Admin;

$credentials = [
    'email' => $_POST['email'],
    'password' => md5($_POST['password'])
];


$admin = new Admin();
$isLoggedIn = $admin->login(...$credentials);
if (! $isLoggedIn) {
    $_SESSION["errors"]['message'] = "Invalid Credentials";
}

header("Location: /");

