<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class Developer extends Model
{

    protected $attributes = [];

    protected $fillable = [
        'name',
        'description',
        'website',
        'created_at',
        'updated_at'
    ];

    protected $table = 'developers';

}