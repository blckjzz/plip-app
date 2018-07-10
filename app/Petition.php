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
        'references',
        'links',
        'sender_name',
        'sender_mail',
        'sender_telephone',
        'submitDate'
    ];

    public $timestamps = false;
    protected $dates = ['submitDate'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

}
