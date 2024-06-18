<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'action',
    ];
}

// RoleUser

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $fillable = [
        'private_id', 'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
