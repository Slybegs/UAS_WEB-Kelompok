<?php

namespace App\Models;

class Customer extends BaseModel
{
    protected string $table = 'customers';

    protected array $fillable = [
        'id', 'name', 'phone_number', 'address'
    ];
}