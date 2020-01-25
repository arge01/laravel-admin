<?php

namespace App\Providers;

use \App\Models\Ayarlar;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $pluk = Ayarlar::pluck('value', 'name')->all();
            config()->set("ayarlar", $pluk);
        } catch(\PDOException $e) {}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return base_path('public_html');
        });
    }
}
