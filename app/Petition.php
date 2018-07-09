<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
    protected $fillable = [
        'plip_status',
        'template',
        'fantasy_name',
        'name',
        'text',
        'wide',
        'plip_status',
        'template',
        'fantasy_name',
        'name',
        'state',
        'municipality',
        'video_url',
        'references', 'links',
        'sender_name',
        'sender_telephone',
        'submitDate'
    ];
}
