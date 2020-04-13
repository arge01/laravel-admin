<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uyeler')->insert([
            'adsoyad'             => 'Arif GEVENCİ',
            'email'               => 'gevenci.arif@gmail.com',
            'sifre'               => '$2y$10$JqOZ05Gme4QlGCgbk.gZQuAmkaKf5jksyVlOR8kj49SVq5neY8HsG',
            'aktivasyon_anahtari' => '1',
            'remember_token'      => '1',
            'rutbeler'            => 1
        ]);

        DB::table('uyeler')->insert([
            'adsoyad'             => 'Yeni Admin',
            'email'               => 'info@domain-adi.com.tr',
            'sifre'               => Hash::make(123),
            'aktivasyon_anahtari' => '1',
            'remember_token'      => '1',
            'rutbeler'            => 1
        ]);
    }
}
