<?php

namespace App\Models;

use App\Core\Url;
use App\Models\BaseModel as Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    protected $appends = [
        'getImage',
    ];

    protected $table = 'categories';

    public function getAssetImage()
    {
        return startsWith($this->attributes['image'], 'http') ? $this->attributes['image'] : Url::asset($this->attributes['image']);
    }
}
