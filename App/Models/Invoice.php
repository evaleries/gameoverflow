<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class Invoice extends Model
{
    protected $attributes = [];

    protected $foreignAttributes = [];

    protected $fillable = [
        'user_id',
        'order_id',
        'no',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $table = 'invoices';
}