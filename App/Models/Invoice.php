<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Invoice extends Model
{
    protected $attributes = [];

    protected $foreignAttributes = [];

    protected $fillable = [
        'order_id',
        'title',
        'no',
        'description',
        'due_date',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'due_date',
    ];

    protected $table = 'invoices';
}
