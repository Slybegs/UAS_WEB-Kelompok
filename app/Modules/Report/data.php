<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;

$date = explode('-', $_GET['month'] ?: date('Y-m'));
$month = $date[1];
$year = $date[0];
$totalSales = new Sales();
$totalSales->query("SELECT products.name as product_name, SUM(sale_details.purchase_price * sale_details.qty) as purchase, SUM(sale_details.total) as sales, sum(sale_details.total - (sale_details.purchase_price * sale_details.qty)) as profit FROM sales 
LEFT JOIN sale_details ON sales.id = sale_details.sales_id 
LEFT JOIN products ON products.id = sale_details.product_id 
WHERE MONTH(sales.date) = '$month' AND YEAR(sales.date) = '$year'
GROUP BY products.name");
$totalSales = $totalSales->get('profit', 'desc');

echo json_encode([
    'data' => $totalSales
]);
 