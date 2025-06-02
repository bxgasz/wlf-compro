<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'image',
        'description'
    ];

    public function news() {
        return $this->hasMany(NewsStories::class);
    }
}
