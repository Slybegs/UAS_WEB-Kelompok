<?php

namespace App\Models;

class Sales extends BaseModel
{
    protected string $table = 'sales';

    protected array $fillable = [
        'id', 'date', 'customer_id', 'total_product', 'total_price', 'note'
    ];
}