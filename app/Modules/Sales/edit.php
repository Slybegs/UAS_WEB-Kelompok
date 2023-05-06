<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;

$sales = new Sales();
$sales->find($id);

$details = new SalesDetail();
$details->query('SELECT product_id, products.name as product_name, sale_details.qty, price FROM sale_details LEFT JOIN products ON products.id = sale_details.product_id');
$details->where('sales_id', '=', $id);
$details = $details->get('sale_details.qty');

$products = new Product();
$products = $products->get();

$categories = new Product();
$categories->query('SELECT DISTINCT category FROM products');
$categories = $categories->get('category');

$customers = new Customer();
$customers->query('SELECT id as `value`, name as `label` FROM customers');
$customers = $customers->get();

echo $twig->render('sales/edit.html.twig', [
    'sales' => $sales->toArray(),
    'details' => $details,
    'products' => $products,
    'categories' => $categories,
    'customers' => $customers
]);