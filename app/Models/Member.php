<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    protected $fillable = [
        'private_id', 'name', 'phone', 'birth', 'safe_ques1', 'safe_ques2', 'safe_ans1', 'safe_ans2',
    ];

    protected $hidden = [
        'safe_ans1', 'safe_ans2',
    ];
    public function account_private()
    {
        return $this->belongsTo(PrivateModel::class);
    }
    public function collect()
    {
        return $this->hasMany(Collect::class);
    }
}