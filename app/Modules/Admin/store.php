<?php

use App\Models\Admin;

$_POST['password'] = md5($_POST['password']);
$admin = new Admin();
$admin->fill($_POST);
if ($admin->save()) {
    header('Location: /admin');
    return;
}
header('Location: /admin/create');

