<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faqs';

    protected $fillable = [
        'question_en',
        'question_id',
        'answer_en',
        'answer_id',
        'category_en',
        'category_id',
    ];
}
