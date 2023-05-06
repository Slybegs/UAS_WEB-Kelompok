<?php

use App\Models\Admin;

$admins = new Admin;
$result = $admins->get();

echo json_encode([
    'data' => $result
]);