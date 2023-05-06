<?php

use App\Models\Product;

$product = new Product();
$product->find($id);

echo $twig->render('product/edit.html.twig', ['product' => $product->toArray()]);