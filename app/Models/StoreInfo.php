<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;

class StoreInfo extends Model
{
    protected $table = 'store_info';

    protected $fillable = [
        'store_id', 'name', 'address', 'intro', 'tag', 'picUrl',
    ];
    protected $guarded = [];
    public function store_private()
    {
        return $this->belongsTo(Store::class);
    }
}
