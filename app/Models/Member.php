<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * 與模型關聯的資料表名稱
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * 可以被批量賦值的屬性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'account',
        'password',
        'email',
        'phone',
        'status',
    ];

    /**
     * 隱藏的屬性
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * 建立新的會員
     *
     * @param  array  $data
     * @return \App\Models\Member
     */
    public static function createMember(array $data)
    {
        return self::create($data);
    }

    /**
     * 取得所有會員
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllMembers()
    {
        return self::all();
    }

    /**
     * 依據 ID 取得會員
     *
     * @param  int  $id
     * @return \App\Models\Member
     */
    public static function getMemberById($id)
    {
        return self::findOrFail($id);
    }

    /**
     * 更新會員資訊
     *
     * @param  int  $id
     * @param  array  $data
     * @return bool
     */
    public static function updateMember($id, array $data)
    {
        $member = self::findOrFail($id);
        return $member->update($data);
    }

    /**
     * 刪除會員
     *
     * @param  int  $id
     * @return bool|null
     */
    public static function deleteMember($id)
    {
        $member = self::findOrFail($id);
        return $member->delete();
    }
}
