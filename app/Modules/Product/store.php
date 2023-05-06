<?php

use App\Models\Product;

$product = new Product();
$product->fill($_POST);
if ($product->save()) {
    header('Location: /product');
    return;
}
header('Location: /product/create');

