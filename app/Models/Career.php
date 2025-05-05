<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'careers';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'location',
        'salary_range',
        'status',
        'type',
        'created_by'
    ];
}
