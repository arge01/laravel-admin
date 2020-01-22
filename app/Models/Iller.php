<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iller extends Model
{
    protected $table = 'muh_iller';

    public function ilceleri()
    {
        return $this->hasMany('App\Models\Ilceler', 'il_id', 'id');
    }

    public function subeleri()
    {
        return $this->hasMany('App\Models\Icerikler', 'il', 'id');
    }
}
