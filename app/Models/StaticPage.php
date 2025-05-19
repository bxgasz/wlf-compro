<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table = 'static_pages';

    protected $fillable = [
        'image',
        'meta_head',
        'meta_description',
        'title_page',
        'slug',
        'content',
    ];
}
