<?php

use App\Models\Admin;

if (isset($_POST['password'])) {
    $_POST['password'] = md5($_POST['password']);
}
$admin = new Admin();
$admin->find($id);
$admin->fill($_POST);
if ($admin->save()) {
    header('Location: /admin');
    return;
}
header('Location: /admin/create');