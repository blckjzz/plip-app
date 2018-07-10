<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'plip_status';
    protected $fillable = ['status'];

    public function petition()
    {
        return $this->hasOne('App\Petition');
    }

}
