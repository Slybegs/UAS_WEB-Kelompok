<?php

use App\Models\Product;

$products = new Product;
$result = $products->get();

echo json_encode([
    'data' => $result
]);