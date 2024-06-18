<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Look extends Model
{
    protected $table = 'look';

    protected $fillable = [
        'store_id', 'date', 'count',
    ];
}
