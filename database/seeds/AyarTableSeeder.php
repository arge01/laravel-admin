<?php

use Illuminate\Database\Seeder;
use App\Models\Ayarlar;

class AyarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ayarlar::query()->truncate();

        Ayarlar::create([
            'name'  => 'baslik',
            'value' => 'ÖRNEK AD'
        ]);

        Ayarlar::create([
            'name'  => 'description',
            'value' => 'ÖRNEK SİTE BAŞLIĞI'
        ]);

        Ayarlar::create([
            'name'  => 'keywords',
            'value' => 'site adı,site başlığı,örnek başlık,başlık'
        ]);

        Ayarlar::create([
            'name'  => 'author',
            'value' => 'Arif GEVENCİ'
        ]);

        Ayarlar::create([
            'name'  => 'author_link',
            'value' => 'http://arifgevenci.com/'
        ]);

        Ayarlar::create([
            'name'  => 'ssl',
            'value' => 0
        ]);

        Ayarlar::create([
            'name'  => 'mail',
            'value' => 'info@domain-adi.com.tr'
        ]);

        Ayarlar::create([
            'name'  => 'tel',
            'value' => '+90 (0) <b>XXX</b> XXX XX XX'
        ]);

        Ayarlar::create([
            'name'  => 'adres',
            'value' => 'XXX XXX XXXX XXXXX / XXXXX'
        ]);

        Ayarlar::create([
            'name'  => 'map',
            'value' => ''
        ]);

        Ayarlar::create([
            'name'  => 'facebook',
            'value' => ''
        ]);

        Ayarlar::create([
            'name'  => 'twitter',
            'value' => ''
        ]);

        Ayarlar::create([
            'name'  => 'instagram',
            'value' => ''
        ]);

        Ayarlar::create([
            'name'  => 'youtube',
            'value' => ''
        ]);
    }
}
