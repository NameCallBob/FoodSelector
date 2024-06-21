<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class PrivateModel extends Model implements AuthenticatableContract, JWTSubject
{
    protected $table = 'private';

    protected $fillable = [
        'account', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function updatePassword($newPassword)
{
    $this->password = Hash::make($newPassword);
    return $this->save();
}
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this -> id,
            'account' => $this->account,
            // 添加您需要的其他自定義聲明
        ];
    }

    // Implement Illuminate\Contracts\Auth\Authenticatable methods
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    // db
    public function store()
    {
        return $this->hasOne(Store::class, 'private_id');
    }
    public function member()
    {
        return $this->hasOne(Member::class, 'private_id');
    }
    public function lock()
    {
        return $this->hasOne(Lock::class, 'private_id');
    }
}
