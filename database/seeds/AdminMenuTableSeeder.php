<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menu')->insert([
            'name' => 'Kategoriler',
            'slug' => 'kategoriler',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Header Ayarları',
            'slug' => 'header-ayarlari',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Sayfalar',
            'slug' => 'sayfalar',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Ürünler',
            'slug' => 'urunler',
            'visible' => 0,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Projeler',
            'slug' => 'projeler',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Sliderlar',
            'slug' => 'sliderlar',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Alt Sliderlar',
            'slug' => 'alt_sliderlar',
            'visible' => 0,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Dosyalar',
            'slug' => 'dosyalar',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Listeler(Sortabla)',
            'slug' => 'listeler',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Görünüm Ayarları',
            'slug' => 'gorunum-ayarlari',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Genel Ayarlar',
            'slug' => 'genel-ayarlar',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Üye Bilgileri',
            'slug' => 'uye-bilgileri',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Ajanda',
            'slug' => 'ajanda',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Referanslar',
            'slug' => 'referanslar',
            'visible' => 1,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Videolar',
            'slug' => 'videolar',
            'visible' => 0,
        ]);

        DB::table('admin_menu')->insert([
            'name' => 'Yorum Ayarlari',
            'slug' => 'videolar',
            'visible' => 0,
        ]);
    }
}
