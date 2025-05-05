<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'link',
        'order_num',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function  parent() {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
