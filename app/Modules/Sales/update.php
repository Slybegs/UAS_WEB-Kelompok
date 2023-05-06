<?php

use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;

$sales = new Sales();
$sales->find($id);
$sales->fill($_POST);
$sales->total_product = count($_POST['detail']);
$sales->save();

$total = 0;
foreach ($_POST['detail'] as $detail) {
    $product = new Product();
    $product->find($detail['product_id']);

    $salesDetail = new SalesDetail();
    $salesDetail->where('product_id', '=', $detail['product_id'])
        ->where('sales_id', '=', $id);
    $old = $salesDetail->get(limit: 1);
    if ($old) {
        $salesDetail->id = $old['id'];
    }
    $salesDetail->sales_id = $sales->id;
    $salesDetail->fill($detail);
    $salesDetail->total = (int) $salesDetail->qty * (int) $salesDetail->price;
    $salesDetail->purchase_price = $salesDetail->purchase_price <= 0 ? $product->purchase_price : $salesDetail->purchase_price;
    $salesDetail->save();
    $total += $salesDetail->total;

    $product->qty = (int) $product->qty - ((int) $salesDetail->qty - (int) ($old['qty'] ?: 0));
    $product->save();
}

$sales->total_price = $total;
if ($sales->save()) {
    header('Location: /sales');
    return;
}
header('Location: /sales/create');

