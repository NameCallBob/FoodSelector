<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $table = 'collect';

    protected $fillable = [
        'member_id', 'products_id',
    ];
}