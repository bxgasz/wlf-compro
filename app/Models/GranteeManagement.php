<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class GranteeManagement extends Authenticatable
{
    protected $table = 'grantee_management';

    protected $fillable = [
        'name',
        'email',
        'foundation',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
