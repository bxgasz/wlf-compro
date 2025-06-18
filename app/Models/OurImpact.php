<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurImpact extends Model
{
    protected $table = 'our_impacts';

    protected $fillable = [
        'title_1',
        'subtitle_1',
        'title_2',
        'subtitle_2',
        'title_3',
        'subtitle_3',
        'title_4',
        'subtitle_4',
        'sdg_title',
        'image',
        'sub_icons',
    ];
}
