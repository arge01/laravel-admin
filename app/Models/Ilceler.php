<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ilceler extends Model
{
    protected $table = 'muh_ilceler';

    public function ili()
    {
        return $this->belongsTo('App\Models\Iller', 'id', 'il_id');
    }

    public function subeleri()
    {
        return $this->hasMany('App\Models\Icerikler', 'ilce', 'id');
    }
}
