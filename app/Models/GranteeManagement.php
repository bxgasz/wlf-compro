<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GranteeManagement extends Model
{
    protected $table = 'grantee_management';

    protected $fillable = [
        'name',
        'email',
        'foundation',
        'password',
    ];
}
