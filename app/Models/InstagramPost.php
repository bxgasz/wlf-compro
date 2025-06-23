<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstagramPost extends Model
{
    protected $table = 'instagram_posts';

    protected $fillable = [
        'link',
        'media'
    ];
}
