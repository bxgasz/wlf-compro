<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'title',
        'address',
        'top',
        'left',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
