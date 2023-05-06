<?php

use App\Models\Sales;

$sales = new Sales;
$sales->query('SELECT sales.id, date, customers.name as customer_name, FORMAT(total_product, 0) as total_product, FORMAT(total_price, 0) as total_price FROM sales LEFT JOIN customers ON customers.id = sales.customer_id');
$result = $sales->get();

echo json_encode([
    'data' => $result
]);