<?php

use App\Models\Product;

$product = new Product();
$product->find($id);
if ($product->delete()) {
    header('Location: /product');
    return;
}
echo 'gagal';