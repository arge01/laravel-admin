<?php

use App\Http\Controllers\AnasayfaController;

Route::group(['prefix' => 'yonetim', 'namespace' => 'Yonetim'], function() {
    Route::redirect('/', config('app.url').'yonetim/oturumac');
    //oturum aç get-post
    Route::match(['get', 'post'], '/oturumac', 'AdminController@oturumac')->name('yonetim.oturumac');
    //middleware
    Route::group(['middleware' => 'yonetici'], function () {
        Route::match(['get', 'post'], '/anasayfa', 'AnasayfaController@anasayfa')->name('yonetim.anasayfa');
        Route::get('/oturumkapat', 'AdminController@oturumkapat')->name('yonetim.oturumkapat');
        //Kategori Yonetimi
        Route::group(['prefix' => '/kategori'], function () {
            Route::match(['get', 'post'], '/', 'KategoriController@kategori')->name('yonetim.kategori.ekle');
            Route::get('/kategoriler', 'KategoriController@listele')->name('yonetim.kategori.listele');
            Route::get('/api', 'KategoriController@api')->name('yonetim.kategori.api');
            Route::match(['post', 'get'], '/sil', 'KategoriController@sil')->name('yonetim.kategori.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'KategoriController@duzenle')->name('yonetim.kategori.duzenle');
        });
        //Sayfa Yönetimi
        Route::group(['prefix' => '/sayfalar'], function () {
            Route::match(['get', 'post'], '/', 'SayfaController@sayfa')->name('yonetim.sayfa.ekle');
            Route::get('/sayfalar', 'SayfaController@listele')->name('yonetim.sayfa.listele');
            Route::match(['get', 'post'], '/sil', 'SayfaController@sil')->name('yonetim.sayfa.sil');
            Route::match(['get', 'post'], 'duzenle/{id}', 'SayfaController@duzenle')->name('yonetim.sayfa.duzenle');
        });
        //Menu Yönetimi
        Route::group(['prefix' => '/menu'], function () {
            Route::match(['get', 'post'], '/', 'MenuController@menu')->name('yonetim.menu.ekle');
            Route::get('/menuler', 'MenuController@listele')->name('yonetim.menu.listele');
            Route::get('/api', 'MenuController@api')->name('yonetim.menu.api');
            Route::match(['get', 'post'], '/sil', 'MenuController@sil')->name('yonetim.menu.sil');
            Route::match(['get', 'post'], '/iliskiler', 'MenuController@iliski')->name('yonetim.menu.iliskiler');
            Route::match(['get', 'post'], 'duzenle/{id}', 'MenuController@duzenle')->name('yonetim.menu.duzenle');
        });
        //Ürün Yönetimi
        Route::group(['prefix' => '/urunler'], function () {
            Route::match(['get','post'], '/', 'UrunController@urun')->name('yonetim.urun.ekle');
            Route::get('/api', 'UrunController@api')->name('yonetim.urunler.api');
            Route::get('/listele', 'UrunController@listele')->name('yonetim.urun.listele');
            Route::match(['get', 'post'], '/sil', 'UrunController@sil')->name('yonetim.urun.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'UrunController@duzenle')->name('yonetim.urun.duzenle');
        });
        //Proje Yönetimi
        Route::group(['prefix' => '/projeler'], function () {
            Route::match(['get','post'], '/', 'ProjeController@urun')->name('yonetim.proje.ekle');
            Route::get('/api', 'ProjeController@api')->name('yonetim.projeler.api');
            Route::get('/listele', 'ProjeController@listele')->name('yonetim.proje.listele');
            Route::match(['get', 'post'], '/sil', 'ProjeController@sil')->name('yonetim.proje.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'ProjeController@duzenle')->name('yonetim.proje.duzenle');
        });
        //Slider Yönetimi
        Route::group(['prefix' => '/sliderlar'], function () {
            Route::match(['get', 'post'], '/', 'SliderController@slider')->name('yonetim.slider.ekle');
            Route::get('/listele', 'SliderController@listele')->name('yonetim.slider.listele');
            Route::match(['get', 'post'], '/sil', 'SliderController@sil')->name('yonetim.slider.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'SliderController@duzenle')->name('yonetim.slider.duzenle');
        });
        //Alt Slider Yönetimi
        Route::group(['prefix' => '/altsliderlar'], function () {
            Route::match(['get', 'post'], '/', 'AltSliderController@slider')->name('yonetim.altslider.ekle');
            Route::get('/listele', 'AltSliderController@listele')->name('yonetim.altslider.listele');
            Route::match(['get', 'post'], '/sil', 'AltSliderController@sil')->name('yonetim.altslider.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'AltSliderController@duzenle')->name('yonetim.altslider.duzenle');
        });
        //Dosya Yönetimi
        Route::group(['prefix' => '/dosyalar'], function () {
            Route::match(['get', 'post'], '/', 'DosyaController@dosyalar')->name('yonetim.dosya.yonetimi');
            Route::match(['get', 'post'], '/duzenle/{id}', 'DosyaController@duzenle')->name('yonetim.dosya.duzenle');
            Route::match(['get', 'post'], '/ekstra', 'DosyaController@ekstra')->name('yonetim.dosya.ekstra');
        });
        //Görünüm Ayarları
        Route::group(['prefix' => '/gorunumler'], function () {
            Route::match(['get', 'post'], '/sayfalar', 'GorunumController@sayfalar')->name('yonetim.gorunum.sayfalar');
            Route::match(['get', 'post'], '/urunler', 'GorunumController@urunler')->name('yonetim.gorunum.urunler');
            Route::match(['get', 'post'], '/slider', 'GorunumController@slider')->name('yonetim.gorunum.slider');
        });
        //Sortabla
        Route::group(['prefix' => '/sortable'], function () {
            Route::match(['get', 'post'], '/sayfalar', 'SortableController@sayfalar')->name('yonetim.sortable.sayfalar');
            Route::match(['get', 'post'], '/urunler', 'SortableController@urunler')->name('yonetim.sortable.urunler');
            Route::match(['get', 'post'], '/urunler/{id}', 'SortableController@secilen')->name('yonetim.sortable.getir');
            Route::match(['get', 'post'], '/sec', 'SortableController@sec')->name('yonetim.sortable.sec');
            Route::match(['get', 'post'], '/slider', 'SortableController@slider')->name('yonetim.sortable.slider');
        });
        //Üye Ayarları
        Route::group(['prefix' => '/uye'], function () {
            Route::match(['get', 'post'], '/ekle', 'UyeController@uye_ekle')->name('yonetim.uye.ekle');
            Route::match(['get', 'post'], '/sil', 'UyeController@sil')->name('yonetim.uye.sil');
            Route::get('/listele', 'UyeController@listele')->name('yonetim.uye.listele');
            Route::match(['get', 'post'], '/yonetici', 'UyeController@yonetici_ekle')->name('yonetim.yonetici.ekle');
            Route::match(['get', 'post'], '/ayarlar', 'UyeController@ayarlar')->name('yonetim.yonetici.ayarlar');
            Route::match(['get', 'post'], '/yoneticiler', 'UyeController@yoneticiler')->name('yonetim.yonetici.listele');
            Route::match(['get', 'post'], '/mail', 'UyeController@mail')->name('yonetim.uyeler.mail');
        });
        //Takvim Ayarları
        Route::group(['prefix' => '/ajanda'], function () {
            Route::match(['get', 'post'], '/', 'TakvimController@takvim')->name('yonetim.takvim.takvim');
            Route::match(['get', 'post'], '/sil', 'TakvimController@sil')->name('yonetim.takvim.sil');
            Route::match(['get', 'post'], '/api', 'TakvimController@api')->name('yonetim.takvim.api');
        });
        //Referans Yonetimi
        Route::group(['prefix' => '/referans'], function () {
            Route::match(['get', 'post'], '/', 'ReferansController@kategori')->name('yonetim.referans.ekle');
            Route::get('/referanslar', 'ReferansController@listele')->name('yonetim.referans.listele');
            Route::match(['post', 'get'], '/sil', 'ReferansController@sil')->name('yonetim.referans.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'ReferansController@duzenle')->name('yonetim.referans.duzenle');
        });
        //Video Yonetimi
        Route::group(['prefix' => '/video'], function () {
            Route::match(['get', 'post'], '/', 'VideoController@kategori')->name('yonetim.video.ekle');
            Route::get('/videolar', 'VideoController@listele')->name('yonetim.video.listele');
            Route::match(['post', 'get'], '/sil', 'VideoController@sil')->name('yonetim.video.sil');
            Route::match(['get', 'post'], '/duzenle/{id}', 'VideoController@duzenle')->name('yonetim.video.duzenle');
        });
        //Galeri Yönetimi
        Route::group(['prefix' => '/galeri'], function () {
            Route::match(['get', 'post'], '/', 'GaleriController@ekle')->name('yonetim.galeri.ekle');
            Route::match(['get', 'post'], '/sil', 'GaleriController@sil')->name('yonetim.galeri.sil');
            Route::match(['get', 'post'], '/duzenle/{gelen}', 'GaleriController@duzenle')->name('yonetim.galeri.duzenle');
            Route::match(['get', 'post'], '/sortable', 'GaleriController@sortable')->name('yonetim.galeri.sortable');
            Route::get('/listele', 'GaleriController@listele')->name('yonetim.galeri.listele');
            Route::match(['get', 'post'], '/sessionla', 'GaleriController@session_al')->name('yonetim.resimleri.al');
        });
        //Yorum Yönetimi
        Route::group(['prefix' => '/yorumlar'], function () {
            Route::match(['get', 'post'], '/', 'YorumController@ekle')->name('yonetim.yorum.ekle');
            Route::match(['get', 'post'], '/sil', 'YorumController@sil')->name('yonetim.yorum.sil');
            Route::match(['get', 'post'], '/duzenle/{gelen}', 'YorumController@duzenle')->name('yonetim.yorum.duzenle');
            Route::get('/listele', 'YorumController@listele')->name('yonetim.yorum.listele');
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
    Route::match(['get', 'post'], '{view}.html', function ($view, AnasayfaController $controller) {
        if (view()->exists($view))
            return $controller->icerikler($view);
        return app()->abort(404, 'Page not found!');
    });
    
    /*
     * route google seo
    */
    Route::get('/api', 'AnasayfaController@api')->name('api');
    Route::get('/sitemap.xml', 'AnasayfaController@sitemap')->name('sitemap.xml');
    Route::get('/rss.xml', 'AnasayfaController@rss')->name('rss.xml');
});
