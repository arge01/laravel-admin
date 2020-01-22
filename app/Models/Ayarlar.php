<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayarlar extends Model
{
    protected $table = 'ayarlar';

    protected $fillable = [
        'name', 'value'
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
}
