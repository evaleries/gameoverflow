<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class Order extends Model
{
    public const AWAITING_PAYMENT = 0;
    public const PROCESSING = 1;
    public const COMPLETED = 2;
    public const CANCELLED = 3;

    protected $table = 'orders';

    protected $attributes = [];

    protected $foreignAttributes = [];

    protected $fillable = [
        'user_id',
        'status',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}