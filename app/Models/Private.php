<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateModel extends Model
{
    protected $table = 'private';

    protected $fillable = [
        'account', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
