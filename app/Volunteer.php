<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'personal_email', 'telephone', 'volunteer_since', 'notes', 'is_active', 'its_scholarship'
    ];

    protected $dates = ['volunteer_since'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    public function analysis()
    {
        return $this->belongsToMany('App\Petition', 'analyses', 'volunteer_id', 'petition_id');
    }
    */

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function analisa()
    {
        return $this->hasOne('App\Analysis');
    }


}
