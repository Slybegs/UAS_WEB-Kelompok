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

$customer = new Customer();
$customer->find($sales->customer_id);

echo $twig->render('sales/print.html.twig', [
    'sales' => $sales->toArray(),
    'details' => $details,
    'customer' => $customer->toArray()
]);