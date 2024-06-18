<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_cate_id', 'store_id', 'name', 'description', 'price', 'picUrl',
    ];
}
