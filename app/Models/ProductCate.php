<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCate extends Model
{
    protected $table = 'product_cate';

    protected $fillable = [
        'name',
    ];
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
