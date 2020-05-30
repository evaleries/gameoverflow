<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class Order extends Model
{
    public const PENDING = 0;
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


    public function getStatusString()
    {
        switch ($this->attributes['status']) {
            case Order::PENDING:
                return 'Pending';
            break;

            case Order::PROCESSING:
                return 'Processing';
            break;

            case Order::COMPLETED:
                return 'Completed';
            break;

            case Order::CANCELLED:
                return 'Cancelled';
            break;
        }
    }

    public function determineStatusClass()
    {
        switch ($this->attributes['status']) {
            case Order::PENDING:
                return 'warning';
            break;

            case Order::PROCESSING:
                return 'primary';
            break;

            case Order::COMPLETED:
                return 'success';
            break;

            case Order::CANCELLED:
                return 'danger';
            break;
        }
    }

}
