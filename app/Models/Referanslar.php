<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referanslar extends Model
{
    protected $table = 'referans';

    protected $fillable = [
        'name', 'img', 'url', 'text',
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
}
