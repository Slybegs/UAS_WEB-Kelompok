<?php

namespace App\Models;

class Product extends BaseModel
{
    protected string $table = 'products';

    protected array $fillable = [
        'id', 'code', 'name', 'category', 'purchase_price', 'sales_price', 'qty'
    ];
}