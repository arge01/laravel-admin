<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeler extends Model
{
    protected $table = 'proje';

    protected $fillable = [
        'name', 'slug', 'img', 'kategori', 'icerik', 'sortable', 'visible', 'label', 'katalog',
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';

    public function kategorisi()
    {
        return $this->belongsTo('App\Models\Kategoriler', 'kategori', 'id');
    }
    public function galerisi()
    {
        return $this->hasMany('App\Models\Galeri', 'proje', 'id');
    }
}
