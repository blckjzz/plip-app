<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $table = 'analyses';

    protected $fillable = [
        'volunteer_id', 'petition_id', 'analisys_text',
        'referral_law', 'law_link', 'percent_votes',
        'vote_number', 'minimum_signatures'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function petition()
    {
        return $this->belongsTo('App\Petition','petition_id');
    }


    public function analista()
    {
        return $this->belongsTo('App\Volunteer', 'volunteer_id');
    }
}
