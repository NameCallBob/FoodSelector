<?php

namespace App\Models;

use App\Models\Product;
use App\Models\PrivateModel;
use App\Models\StoreInfo;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';

    protected $fillable = [
        'private_id', 'phone', 'email', 'owner_name',
    ];
    protected $guarded = [];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function account_private()
    {
        return $this->belongsTo(PrivateModel::class);
    }
    public function info()
    {
        return $this->hasOne(StoreInfo::class);
    }
}
