<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = [
        'name', 'personal_email', 'volunteer_mail', 'telephone', 'volunteer_since', 'notes'
    ];

}