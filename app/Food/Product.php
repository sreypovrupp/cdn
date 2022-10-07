<?php

namespace App\Food;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'name',
        'name_kh',
        'price',
        'photo',
        'dsc',
        'category'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category');
    }
}
