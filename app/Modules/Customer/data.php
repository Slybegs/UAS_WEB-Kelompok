<?php

use App\Models\Customer;

$customers = new Customer;
$result = $customers->get();

echo json_encode([
    'data' => $result
]);