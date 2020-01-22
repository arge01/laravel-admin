<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icerikler extends Model
{
    protected $table = 'icerikler';

    protected $fillable = [
        'sayfasi', 'name', 'label' ,'slug', 'icerik', 'visible', 'il', 'ilce'
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';

    public function sayfa()
    {
        return $this->belongsTo('App\Models\Sayfalar', 'sayfasi', 'id');
    }
}
