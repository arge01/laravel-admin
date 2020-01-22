<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yorumlar extends Model
{
    protected $table = 'yourumlar';

    protected $fillable = [
        'name', 'img', 'text', 'sortable', 'visible', 'slug',
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
}
