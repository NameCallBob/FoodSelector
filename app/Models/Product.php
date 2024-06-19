<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_cate_id', 'store_id', 'name', 'description', 'price', 'picUrl',
    ];
    protected $hidden = [
        'updated_at', 'created_at',
    ];

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ProductCate::class, 'product_cate_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
