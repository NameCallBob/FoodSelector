<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';

    protected $fillable = [
        'private_id', 'phone', 'email', 'owner_name',
    ];
}
