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
            'adsoyad'             => 'Yeni Admin',
            'email'               => 'info@domain-adi.com.tr',
            'sifre'               => Hash::make('crypte hash şifre'),
            'aktivasyon_anahtari' => '1',
            'remember_token'      => '1',
            'rutbeler'            => 1
        ]);
    }
}
