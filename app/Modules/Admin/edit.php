<?php

use App\Models\Admin;

$admin = new Admin();
$admin->find($id);

echo $twig->render('admin/edit.html.twig', ['admin' => $admin->toArray()]);