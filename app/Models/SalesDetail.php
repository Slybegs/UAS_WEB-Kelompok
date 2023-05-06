<?php

namespace App\Models;

class SalesDetail extends BaseModel
{
    protected string $table = 'sale_details';

    protected array $fillable = [
        'id', 'sales_id', 'product_id', 'purchase_price', 'price', 'qty', 'total',
    ];
}