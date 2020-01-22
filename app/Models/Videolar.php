<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videolar extends Model
{
    protected $table = 'video';

    protected $fillable = [
        'name', 'img', 'url'
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
}
