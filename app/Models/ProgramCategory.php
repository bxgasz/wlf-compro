<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramCategory extends Model
{
    protected $table = 'program_categories';

    protected $fillable = [
        'title',
        'summary',
        'description',
        'slug',
        'image',
    ];

    public function programs() {
        return $this->hasMany(Program::class);
    }
}
