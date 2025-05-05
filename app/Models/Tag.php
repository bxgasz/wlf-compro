<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'title',
        'description'
    ];

    public function news()
    {
        return $this->belongsToMany(NewsStories::class, 'tags_news_stories', 'tag_id', 'news_id');
    }
}
