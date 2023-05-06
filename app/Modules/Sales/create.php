<?php

use App\Models\Customer;
use App\Models\Product;

$products = new Product();
$products = $products->get();

$categories = new Product();
$categories->query('SELECT DISTINCT category FROM products');
$categories = $categories->get('category');

$customers = new Customer();
$customers->query('SELECT id as `value`, name as `label` FROM customers');
$customers = $customers->get();

echo $twig->render('sales/create.html.twig', [
    'products' => $products,
    'categories' => $categories,
    'customers' => $customers
]);