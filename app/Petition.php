<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Petition extends Model
{

    protected $fillable = [
        'template',
        'fantasy_name',
        'name',
        'text',
        'wide',
        'status_id',
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

    protected $dates = ['submitDate'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }


    /*
    public function analysis()
    {
        return $this->belongsToMany('App\Volunteer', 'analyses',
                                    'petition_id',
                                    'volunteer_id')
                                    ->withPivot('volunteer_id', 'petition_id', 'analisys_text',
                                        'referral_law', 'law_link', 'percent_votes',
                                        'vote_number', 'minimum_signatures');
    }
    */

    public function analise()
    {
        return $this->hasOne('App\Analysis');
    }





}
