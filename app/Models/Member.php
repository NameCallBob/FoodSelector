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
}