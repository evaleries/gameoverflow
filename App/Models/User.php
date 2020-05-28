<?php


namespace App\Models;

use App\Models\BaseModel as Model;

class User extends Model
{
    public const ADMIN = 1;
    public const USER = 2;

    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'recovery_code',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'getRoleName'
    ];

    protected $hidden = [
        'password'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $table = 'users';

    public function isAdmin()
    {
        return $this->attributes['role'] == User::ADMIN;
    }

    public function getRoleName()
    {
        return $this->isAdmin() ? 'ADMIN' : 'USER';
    }

}