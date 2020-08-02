<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Product extends Model
{
    protected $fillable = [
        'developer_id',
        'code',
        'title',
        'slug',
        'price',
        'image',
        'short_description',
        'description',
        'category_id',
        'released_at',
        'updated_at',
        'created_at',
    ];

    protected $foreignAttributes = [];

    protected $table = 'products';

    public function getAssetImage()
    {
        return (startsWith($this->attributes['image'], 'http')) ? $this->attributes['image'] : \App\Core\Url::asset($this->attributes['image']);
    }

    public function getReleasedAt($format = 'j F Y')
    {
        return (new \DateTime($this->attributes['released_at']))->format($format);
    }

    public function getFormattedPrice()
    {
        return self::humanizePrice($this->attributes['price']);
    }

    public static function humanizePrice($price)
    {
        return ($price > 0) ? 'Rp. '.number_format($price, 0, '.', ',').',-' : 'Gratis';
    }
}
