<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class Product extends Model
{
    // protected $hidden = [
    //     'category',
    // ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    protected $fillable = [
        'name', 'description', 'price', 'stock_quantity', 'category_id'
    ];
}
