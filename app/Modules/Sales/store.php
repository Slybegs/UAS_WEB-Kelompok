<?php

use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;

$sales = new Sales();
$sales->date = date('Y-m-d');
$sales->fill($_POST);
$sales->total_product = count($_POST['detail']);
$sales->save();

$total = 0;
foreach ($_POST['detail'] as $detail) {
    $product = new Product();
    $product->find($detail['product_id']);

    $salesDetail = new SalesDetail();
    $salesDetail->sales_id = $sales->id;
    $salesDetail->fill($detail);
    $salesDetail->purchase_price = $product->purchase_price;
    $salesDetail->total = (int) $salesDetail->qty * (int) $salesDetail->price;
    $salesDetail->save();
    $total += $salesDetail->total;

    $product->qty = (int) $product->qty - (int) $salesDetail->qty;
    $product->save();
}

$sales->total_price = $total;
if ($sales->save()) {
    header('Location: /sales');
    return;
}
header('Location: /sales/create');

