<?php

use App\Http\Controllers\AnasayfaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'yonetim', 'namespace' => 'Yonetim', 'as' => 'yonetim.'], function() {
    Route::redirect('/', config('app.url').'yonetim/oturumac');
    //oturum aç get-post
    Route::match(['get', 'post'], '/oturumac', 'AdminController@oturumac')->name('oturumac');
    //middleware
    Route::group(['middleware' => 'yonetici'], function () {
        Route::match(['get', 'post'], '/anasayfa', 'AnasayfaController@anasayfa')->name('anasayfa');
        Route::get('/oturumkapat', 'AdminController@oturumkapat')->name('oturumkapat');
        //Kategori Yonetimi
        Route::group(['prefix' => '/kategori'], function () {
            Route::match(['get', 'post'], '/', 'KategoriController@kategori')->name('kategori.ekle');
            Route::get('/kategoriler', 'KategoriController@listele')->name('kategori.listele');
            Route::get('/api', 'KategoriController@api')->name('kategori.api');
            Route::match(['post', 'get'], '/sil', 'KategoriController@sil')->name('kategori.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'KategoriController@duzenle')->name('kategori.duzenle');
        });
        //Sayfa Yönetimi
        Route::group(['prefix' => '/sayfalar'], function () {
            Route::match(['get', 'post'], '/', 'SayfaController@sayfa')->name('sayfa.ekle');
            Route::get('/sayfalar', 'SayfaController@listele')->name('sayfa.listele');
            Route::match(['get', 'post'], '/sil', 'SayfaController@sil')->name('sayfa.sil');
            Route::match(['get', 'post'], 'duzenle/{id}', 'SayfaController@duzenle')->name('sayfa.duzenle');
        });
        //Menu Yönetimi
        Route::group(['prefix' => '/menu'], function () {
            Route::match(['get', 'post'], '/', 'MenuController@menu')->name('menu.ekle');
            Route::get('/menuler', 'MenuController@listele')->name('menu.listele');
            Route::get('/api', 'MenuController@api')->name('menu.api');
            Route::match(['get', 'post'], '/sil', 'MenuController@sil')->name('menu.sil');
            Route::match(['get', 'post'], '/iliskiler', 'MenuController@iliski')->name('menu.iliskiler');
            Route::match(['get', 'post'], 'duzenle/{id}', 'MenuController@duzenle')->name('menu.duzenle');
        });
        //Ürün Yönetimi
        Route::group(['prefix' => '/urunler'], function () {
            Route::match(['get','post'], '/', 'UrunController@urun')->name('urun.ekle');
            Route::get('/api', 'UrunController@api')->name('urunler.api');
            Route::get('/listele', 'UrunController@listele')->name('urun.listele');
            Route::match(['get', 'post'], '/sil', 'UrunController@sil')->name('urun.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'UrunController@duzenle')->name('urun.duzenle');
        });
        //Proje Yönetimi
        Route::group(['prefix' => '/projeler'], function () {
            Route::match(['get','post'], '/', 'ProjeController@urun')->name('proje.ekle');
            Route::get('/api', 'ProjeController@api')->name('projeler.api');
            Route::get('/listele', 'ProjeController@listele')->name('proje.listele');
            Route::match(['get', 'post'], '/sil', 'ProjeController@sil')->name('proje.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'ProjeController@duzenle')->name('proje.duzenle');
        });
        //Slider Yönetimi
        Route::group(['prefix' => '/sliderlar'], function () {
            Route::match(['get', 'post'], '/', 'SliderController@slider')->name('slider.ekle');
            Route::get('/listele', 'SliderController@listele')->name('slider.listele');
            Route::match(['get', 'post'], '/sil', 'SliderController@sil')->name('slider.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'SliderController@duzenle')->name('slider.duzenle');
        });
        //Alt Slider Yönetimi
        Route::group(['prefix' => '/altsliderlar'], function () {
            Route::match(['get', 'post'], '/', 'AltSliderController@slider')->name('altslider.ekle');
            Route::get('/listele', 'AltSliderController@listele')->name('altslider.listele');
            Route::match(['get', 'post'], '/sil', 'AltSliderController@sil')->name('altslider.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'AltSliderController@duzenle')->name('altslider.duzenle');
        });
        //Dosya Yönetimi
        Route::group(['prefix' => '/dosyalar'], function () {
            Route::match(['get', 'post'], '/', 'DosyaController@dosyalar')->name('dosya.yonetimi');
            Route::match(['get', 'post'], '/duzenle/{id}', 'DosyaController@duzenle')->name('dosya.duzenle');
            Route::match(['get', 'post'], '/ekstra', 'DosyaController@ekstra')->name('dosya.ekstra');
        });
        //Görünüm Ayarları
        Route::group(['prefix' => '/gorunumler'], function () {
            Route::match(['get', 'post'], '/sayfalar', 'GorunumController@sayfalar')->name('gorunum.sayfalar');
            Route::match(['get', 'post'], '/urunler', 'GorunumController@urunler')->name('gorunum.urunler');
            Route::match(['get', 'post'], '/slider', 'GorunumController@slider')->name('gorunum.slider');
        });
        //Sortabla
        Route::group(['prefix' => '/sortable'], function () {
            Route::match(['get', 'post'], '/sayfalar', 'SortableController@sayfalar')->name('sortable.sayfalar');
            Route::match(['get', 'post'], '/urunler', 'SortableController@urunler')->name('sortable.urunler');
            Route::match(['get', 'post'], '/urunler/{id}', 'SortableController@secilen')->name('sortable.getir');
            Route::match(['get', 'post'], '/sec', 'SortableController@sec')->name('sortable.sec');
            Route::match(['get', 'post'], '/slider', 'SortableController@slider')->name('sortable.slider');
        });
        //Üye Ayarları
        Route::group(['prefix' => '/uye'], function () {
            Route::match(['get', 'post'], '/ekle', 'UyeController@uye_ekle')->name('uye.ekle');
            Route::match(['get', 'post'], '/sil', 'UyeController@sil')->name('uye.sil');
            Route::get('/listele', 'UyeController@listele')->name('uye.listele');
            Route::match(['get', 'post'], '/yonetici', 'UyeController@yonetici_ekle')->name('yonetici.ekle');
            Route::match(['get', 'post'], '/ayarlar', 'UyeController@ayarlar')->name('yonetici.ayarlar');
            Route::match(['get', 'post'], '/yoneticiler', 'UyeController@yoneticiler')->name('yonetici.listele');
            Route::match(['get', 'post'], '/mail', 'UyeController@mail')->name('uyeler.mail');
        });
        //Takvim Ayarları
        Route::group(['prefix' => '/ajanda'], function () {
            Route::match(['get', 'post'], '/', 'TakvimController@takvim')->name('takvim.takvim');
            Route::match(['get', 'post'], '/sil', 'TakvimController@sil')->name('takvim.sil');
            Route::match(['get', 'post'], '/api', 'TakvimController@api')->name('takvim.api');
        });
        //Referans Yonetimi
        Route::group(['prefix' => '/referans'], function () {
            Route::match(['get', 'post'], '/', 'ReferansController@kategori')->name('referans.ekle');
            Route::get('/referanslar', 'ReferansController@listele')->name('referans.listele');
            Route::match(['post', 'get'], '/sil', 'ReferansController@sil')->name('referans.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'ReferansController@duzenle')->name('referans.duzenle');
        });
        //Video Yonetimi
        Route::group(['prefix' => '/video'], function () {
            Route::match(['get', 'post'], '/', 'VideoController@kategori')->name('video.ekle');
            Route::get('/videolar', 'VideoController@listele')->name('video.listele');
            Route::match(['post', 'get'], '/sil', 'VideoController@sil')->name('video.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'VideoController@duzenle')->name('video.duzenle');
        });
        //Galeri Yönetimi
        Route::group(['prefix' => '/galeri'], function () {
            Route::match(['get', 'post'], '/', 'GaleriController@ekle')->name('galeri.ekle');
            Route::match(['get', 'post'], '/sil', 'GaleriController@sil')->name('galeri.sil');
            Route::match(['get', 'post'], '/duzenle/{gelen}', 'GaleriController@duzenle')->name('galeri.duzenle');
            Route::match(['get', 'post'], '/sortable', 'GaleriController@sortable')->name('galeri.sortable');
            Route::get('/listele', 'GaleriController@listele')->name('galeri.listele');
            Route::match(['get', 'post'], '/sessionla', 'GaleriController@session_al')->name('resimleri.al');
        });
        //Yorum Yönetimi
        Route::group(['prefix' => '/yorumlar'], function () {
            Route::match(['get', 'post'], '/', 'YorumController@ekle')->name('yorum.ekle');
            Route::match(['get', 'post'], '/sil', 'YorumController@sil')->name('yorum.sil');
            Route::match(['get', 'post'], '/duzenle/{gelen}', 'YorumController@duzenle')->name('yorum.duzenle');
            Route::get('/listele', 'YorumController@listele')->name('yorum.listele');
        });
    });
});
Route::group(['prefix' => ''], function(){
    /*
    * route anasayfa
    */
    Route::get('/', 'AnasayfaController@anasayfa')->name('anasayfa');
    Route::get('/index.html', 'AnasayfaController@anasayfa')->name('anasayfa');
    /*
    * route mail
    */
    Route::match(['get', 'post'],'/mailgonder', 'AnasayfaController@mailgonder')->name('mail.gonder');
    
    /*
     * route any file
    */
    Route::group(['as'=>'sayfa'], function() {
        Route::match(['get', 'post'], '{view}.html', function ($view, AnasayfaController $controller) {
            if ( view()->exists("pages/".$view) )
                return $controller->icerikler($view);
            return $controller->sayfalar($view);
        });
    });
    
    /*
     * route google seo
    */
    Route::get('/api', 'AnasayfaController@api')->name('api');
    Route::get('/sitemap.xml', 'AnasayfaController@sitemap')->name('sitemap.xml');
    Route::get('/rss.xml', 'AnasayfaController@rss')->name('rss.xml');
});
