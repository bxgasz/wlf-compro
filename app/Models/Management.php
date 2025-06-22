<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $table = 'management';

    protected $fillable = [
        'title',
        'image',
        'description',
        'position',
        'is_active',
        'link_fb',
        'link_ig',
        'link_linkedin',
    ];
}
