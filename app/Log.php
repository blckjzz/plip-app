<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'quantity',
        'sync_date',
        'motive'
    ];

    public $timestamps = false;

    protected $dates = ['sync_date'];
}
