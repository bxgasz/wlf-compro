<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepCFCN extends Model
{
    protected $table = 'step_cfcns';

    protected $fillable = [
        'title',
        'description',
        'order',
        'image',
        'file'
    ];
}
