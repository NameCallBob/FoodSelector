<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    // 指定資料表名稱
    protected $table = 'store';

    // 允許批量賦值的欄位
    protected $fillable = [
        'private_id', 'name', 'address', 'intro', 'tag', 'phone', 'email', 'owner_name'
    ];

    // 定義與 `private` 資料表的關聯
    public function private()
    {
        return $this->belongsTo('App\Models\PrivateModel', 'private_id');
    }
}