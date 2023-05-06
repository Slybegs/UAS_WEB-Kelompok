<?php

use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;

$sales = new Sales();
$sales->find($id);

$details = new SalesDetail();
$details->where('sales_id', '=', $id);
$details = $details->get();
foreach ($details as $detail) {
    $product = new Product();
    $product->find($detail['product_id']);
    $product->qty = (int) $product->qty + (int) $detail['qty'];
    $product->save();

    $salesDetail = new SalesDetail();
    $salesDetail->fill($detail);
    $salesDetail->delete();
}

if ($sales->delete()) {
    header('Location: /sales');
    return;
}
echo 'gagal';