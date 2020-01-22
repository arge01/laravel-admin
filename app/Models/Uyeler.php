<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Uyeler extends Authenticatable
{
    protected $table = 'uyeler';

    protected $fillable = [
        'adsoyad', 'email', 'sifre', 'aktivasyon_anahtari', 'aktivasyon_durumu', 'img', 'rutbeler',
    ];

    protected $hidden = [
        'sifre', 'aktivasyon_anahtari',
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';

    public function getAuthPassword(){
        return $this->sifre;
    }
}
