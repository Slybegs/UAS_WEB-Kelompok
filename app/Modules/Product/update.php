<?php

use App\Models\Product;

$product = new Product();
$product->find($id);
$product->fill($_POST);
if ($product->save()) {
    header('Location: /product');
    return;
}
header('Location: /product/create');