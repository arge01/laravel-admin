<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Altslider extends Model
{
    protected $table = 'altslider';

    protected $fillable = [
        'name', 'slug', 'label', 'icerik', 'img', 'sortable', 'visible', 'link'
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
}
