<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'title',
        'favicon',
        'logo',
        'email',
        'phone_no',
        'instagram_url',
        'facebook_url',
        'linkedin_url',
        'x_url',
        'tiktok_url',
        'youtube_url',
        'location',
        'gmap_url',
        'footer_notes',

        'show_organization',
        'show_team',
        'show_donate_button',

        'cta_title',
        'cta_link',
        'show_cta'
    ];
}
