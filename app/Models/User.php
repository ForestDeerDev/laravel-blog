<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. 引入工厂 Trait 的命名空间
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory; // 2. 在类内部启用这个 Trait

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = ['email', 'password'];

    // 可选：密码自动加密
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }
}