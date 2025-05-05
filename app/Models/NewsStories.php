<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsStories extends Model
{
    protected $table = 'news_stories';

    protected $fillable = [
        'meta_title',
        'meta_description',
        'title',
        'type',
        'slug',
        'content',
        'banner',
        'writter',
        'editor_by',
        'status',
        'created_by',
        'category_id',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_news_stories');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
