<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    protected $fillable = [
        'count',
        'status',
        'private_id'
    ];

    public function private()
    {
        return $this->belongsTo(PrivateModel::class, 'private_id');
    }

    public function incrementCount()
    {
        $this->count += 1;
        $this->save();
    }
}
