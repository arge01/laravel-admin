<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sayfalar extends Model
{
    protected $table = 'sayfalar';

    protected $fillable = [
        'name', 'belong', 'slug', 'sortable', 'content', 'visible', 'link', 'url', 'target', 'il', 'ilce'
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';

    public function tablari()
    {
        return $this->hasMany($this, 'belong');
    }

    public function sahibi()
    {
        return $this->belongsTo($this, 'belong', 'id');
    }

    public function icerigi()
    {
        return $this->belongsTo('App\Models\Icerikler', 'id', 'sayfasi');
    }

    public function galerisi()
    {
        return $this->hasMany('App\Models\Galeri', 'sayfa', 'id');
    }
}
