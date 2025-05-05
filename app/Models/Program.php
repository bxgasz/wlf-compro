<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';

    protected $fillable = [
        'title',
        'implementing_partner',
        'sector',
        'slug',
        'location',
        'start_date',
        'end_date',
        'youtube_link',
        'banner',
        'description',
        'document',
        'program_category_id',
    ];

    public function programCategory()
    {
        return $this->hasOne(ProgramCategory::class, 'id', 'program_category_id');
    }
}
