<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreInfo extends Model
{
    protected $table = 'store_info';

    protected $fillable = [
        'store_id', 'name', 'address', 'intro', 'tag', 'picUrl',
    ];
}
