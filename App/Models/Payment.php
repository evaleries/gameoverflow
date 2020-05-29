<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class Payment extends Model
{
    protected $attributes = [];

    protected $foreignAttributes = [];

    protected $fillable = [
        'order_id',
        'amount',
        'bank_name',
        'bank_number',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'payments';

}