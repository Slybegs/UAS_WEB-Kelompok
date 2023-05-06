<?php

use App\Models\Admin;

$admin = new Admin();
$admin->find($id);
if ($admin->delete()) {
    header('Location: /admin');
    return;
}
echo 'gagal';