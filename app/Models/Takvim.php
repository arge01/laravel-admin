<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Takvim extends Model
{
    protected $table = 'ajanda';

    protected $fillable = [
        'title', 'color', 'year', 'startmonth', 'startday', 'starthour', 'endmonth', 'endday', 'endhour',
    ];

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
}
