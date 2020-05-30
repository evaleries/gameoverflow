<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class Payment extends Model
{

    public const PENDING = 0;
    public const CONFIRMED = 1;

    protected $attributes = [];

    protected $foreignAttributes = [];

    protected $fillable = [
        'order_id',
        'amount',
        'bank_name',
        'bank_number',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'payments';


    public function getUpdatedAtFormat($format = 'j F Y')
    {
        return (new \DateTime($this->attributes['updated_at']))->format($format);
    }

}