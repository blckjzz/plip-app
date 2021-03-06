<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{

    protected $fillable = [
        'personal_email', 'telephone', 'volunteer_since', 'notes', 'is_active', 'its_scholarship'
    ];

    protected $dates = ['volunteer_since'];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function analises()
    {
        return $this->hasMany('App\Analysis', 'volunteer_id');
    }


}
