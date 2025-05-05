<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inboxes';

    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'subject',
        'message',
        'is_read',
    ];
}
