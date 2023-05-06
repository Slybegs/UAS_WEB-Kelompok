<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;


$totalSales = new Sales();
$totalSales->query('SELECT sum(total_price) as total FROM sales');
$totalSales = $totalSales->get();

$totalCustomer = new Customer();
$totalCustomer->query('SELECT count(*) as total FROM customers');
$totalCustomer = $totalCustomer->get();

$totalProfit = new SalesDetail();
$totalProfit->query('SELECT sum(sale_details.total - (sale_details.purchase_price * sale_details.qty)) as total FROM sale_details');
$totalProfit = $totalProfit->get('total', 'desc', 5);

$top5Products = new SalesDetail();
$top5Products->query('SELECT products.name as product_name, sum(sale_details.qty) as total_sales FROM sale_details LEFT JOIN products ON products.id = sale_details.product_id GROUP BY products.name');
$top5Products = $top5Products->get('total_sales', 'desc', 5);

//get product with qty less than or equal to 5
$lowSupplyProducts = new Product();
$lowSupplyProducts->query('SELECT name, qty FROM products');
$lowSupplyProducts->where('qty', '<=', 5);
$lowSupplyProducts = $lowSupplyProducts->get('qty');

$top5Customers = new Sales();
$top5Customers->query('SELECT customers.name as customer_name, sum(sales.total_price) as total_purchase FROM sales LEFT JOIN customers ON customers.id = sales.customer_id GROUP BY customers.name');
$top5Customers = $top5Customers->get('total_purchase', 'desc', 5);

$totalSalesMonthly = new Sales();
$totalSalesMonthly->query('SELECT DATE_FORMAT(date, "%m") as month, sum(total_price) as total FROM sales WHERE DATE_FORMAT(date, "%Y") = YEAR(CURDATE()) GROUP BY month');
$totalSalesMonthly = $totalSalesMonthly->get('month');
$totalSalesPerMonth = [];
for ($x = 1; $x <= 12; $x++) {
    $match = false;
    foreach ($totalSalesMonthly as $sales) {
        if ($sales['month'] === str_pad($x, 2, '0', STR_PAD_LEFT)) {
            $totalSalesPerMonth[] = (int) $sales['total'];
            $match = true;
            break;
        }
    }
    if (!$match) {
        $totalSalesPerMonth[] = 0;
    }
}

echo $twig->render('dashboard.html.twig', [
    'totalProfit' => $totalProfit[0]['total'] ?: 0,
    'totalSales' => $totalSales[0]['total'] ?: 0,
    'totalCustomer' => $totalCustomer[0]['total'] ?: 0,
    'totalSalesPerMonth' => $totalSalesPerMonth,
    'top5Products' => $top5Products,
    'top5Customers' => $top5Customers,
    'lowSupplyProducts' => $lowSupplyProducts,
]);
