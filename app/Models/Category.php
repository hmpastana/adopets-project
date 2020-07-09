<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class Category extends Model
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    protected $keyType = 'string';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'products',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function listAll()
    {
        // return $this->hasMany('App\Models\Product');
        $category = Category::select()
            ->join('products', 'category.id', 'category_id')
            ->get();

        return $category;
        // return $this->hasMany('App\Models\Product');
    }

}
