<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategoriler extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'name', 'belong', 'slug', 'sortable', 'img', 'visible'
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';

    public function alt_kategorileri()
    {
        return $this->hasMany($this, 'belong');
    }

    public function ana_kategori()
    {
        return $this->belongsTo($this, 'belong', 'id');
    }

    public function urunler()
    {
        return $this->hasMany('App\Models\Urunler', 'kategori', 'id');
    }

    public function projeler()
    {
        return $this->hasMany('App\Models\Projeler', 'kategori', 'id');
    }
}
