<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'title',
        'desc',
        'media',
        'is_active',
        'type',
        'link_01',
        'link_02',
        'order_num',
        'created_by'
    ];
}
