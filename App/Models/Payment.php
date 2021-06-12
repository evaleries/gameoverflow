<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use DateTime;

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
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'payments';

    public function getPaymentStatus()
    {
        return ($this->attributes['status'] == Payment::CONFIRMED) ? 'Terkonfirmasi' : 'Belum Terkonfirmasi';
    }

    public function getUpdatedAtFormat($format = 'j F Y')
    {
        return (new DateTime($this->attributes['updated_at']))->format($format);
    }

    public function formattedAmount()
    {
        return ($this->attributes['amount'] > 0) ? 'Rp. ' . number_format($this->attributes['amount'], 0, '.', ',') . ',-' : '0';
    }
}
