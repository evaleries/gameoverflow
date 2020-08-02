<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $attributes = [];

    protected $foreignAttributes = [];

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'discount',
    ];
}
