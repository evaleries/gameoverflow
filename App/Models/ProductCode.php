<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class ProductCode extends Model
{
    public const AVAILABLE = 0;
    public const REDEEMED = 1;

    protected $attributes = [];

    protected $fillable = [
        'product_id',
        'user_id',
        'status',
        'activation_code',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'product_codes';
}