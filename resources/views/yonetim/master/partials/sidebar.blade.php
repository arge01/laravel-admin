<aside id="sidebar_main">

    <div class="sidebar_main_header">
        <div class="sidebar_logo">
            <a href="{{ route('yonetim.anasayfa') }}" class="sSidebar_hide"><img src="{{ config('app.url').'admin/' }}assets/img/logo_main.png" alt="" height="15" width="71"/></a>
            <a href="{{ route('yonetim.anasayfa') }}" class="sSidebar_show"><img src="{{ config('app.url').'admin/' }}assets/img/logo_main_small.png" alt="" height="32" width="32"/></a>
        </div>
    </div>

    <div class="menu_section">
        <ul class="menu_all">
            <li class="{{ request()->is('yonetim/anasayfa') ? 'current_section' : '' }}" title="Anasayfa">
                <a href="{{ route('yonetim.anasayfa') }}">
                    <span class="menu_icon"><i class="material-icons">&#xE88A;</i></span>
                    <span class="menu_title">Anasayfa</span>
                </a>
            </li>
            <li id="kategoriler" class="{{ request()->is('yonetim/kategori') ? 'current_section' : '' }}" title="Kategoriler">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">Kategoriler</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/kategori') ? 'act_item' : '' }}"><a href="{{ route('yonetim.kategori.ekle') }}">Yeni Kategori</a></li>
                    <li class="{{ request()->is('yonetim/kategori/kategoriler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.kategori.listele') }}">Kategoriler</a></li>
                </ul>
            </li>
            <li id="referanslar" class="{{ request()->is('yonetim/referans') ? 'current_section' : '' }}" title="Referanslar">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">style</i></span>
                    <span class="menu_title">Referanslar</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/referans') ? 'act_item' : '' }}"><a href="{{ route('yonetim.referans.ekle') }}">Yeni Referans</a></li>
                    <li class="{{ request()->is('yonetim/referans/referanslar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.referans.listele') }}">Referanslar</a></li>
                </ul>
            </li>
            <li id="videolar" class="{{ request()->is('yonetim/video') ? 'current_section' : '' }}" title="Videolar">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">play_arrow</i></span>
                    <span class="menu_title">Videolar</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/video') ? 'act_item' : '' }}"><a href="{{ route('yonetim.video.ekle') }}">Yeni Video</a></li>
                    <li class="{{ request()->is('yonetim/video/videolar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.video.listele') }}">Videolar</a></li>
                </ul>
            </li>
            <li id="galeri" class="{{ request()->is('yonetim/galeri') ? 'current_section' : '' }}" title="Galeri">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">collections</i></span>
                    <span class="menu_title">Galeri</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/galeri') ? 'act_item' : '' }}"><a href="{{ route('yonetim.galeri.ekle') }}">Yeni Galeri</a></li>
                    <li class="{{ request()->is('yonetim/galeri/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.galeri.listele') }}">Galeriler</a></li>
                </ul>
            </li>
            <li id="header-ayarlari" class="{{ request()->is('yonetim/menu') ? 'current_section' : '' }}" title="Menü Ayarları">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">loyalty</i></span>
                    <span class="menu_title">Menü Ayarları</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/menu') ? 'act_item' : '' }}"><a href="{{ route('yonetim.menu.ekle') }}">Yeni Menü</a></li>
                    <li class="{{ request()->is('yonetim/menu/menuler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.menu.listele') }}">Menüler</a></li>
                    <li class="{{ request()->is('yonetim/menu/iliskiler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.menu.iliskiler') }}">İlişki ayarları</a></li>
                </ul>
            </li>
            <li id="sayfalar" class="{{ request()->is('yonetim/sayfalar') ? 'current_section' : '' }}" title="Sayfalar">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">library_books</i></span>
                    <span class="menu_title">Sayfalar</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/sayfalar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.sayfa.ekle') }}">Yeni Sayfa</a></li>
                    <li class="{{ request()->is('yonetim/sayfalar/sayfalar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.sayfa.listele') }}">Sayfalar</a></li>
                </ul>
            </li>
            <li id="urunler" class="{{ request()->is('yonetim/urunler') ? 'current_section' : '' }}" title="Ürünler">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                    <span class="menu_title">Ürünler</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/urunler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.urun.ekle') }}">Yeni Ürün</a></li>
                    <li class="{{ request()->is('yonetim/urunler/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.urun.listele') }}">Ürünler</a></li>
                </ul>
            </li>
            <li id="projeler" class="{{ request()->is('yonetim/projeler') ? 'current_section' : '' }}" title="Projeler">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                    <span class="menu_title">Ürünler</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/projeler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.proje.ekle') }}">Yeni Ürün</a></li>
                    <li class="{{ request()->is('yonetim/projeler/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.proje.listele') }}">Ürünler</a></li>
                </ul>
            </li>
            <li id="sliderlar" class="{{ request()->is('yonetim/slider') ? 'current_section' : '' }}" title="Slider">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">theaters</i></span>
                    <span class="menu_title">Sliderlar</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/sliderlar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.slider.ekle') }}">Yeni Slider</a></li>
                    <li class="{{ request()->is('yonetim/sliderlar/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.slider.listele') }}">Sliderlar</a></li>
                </ul>
            </li>
            <li id="alt_sliderlar" class="{{ request()->is('yonetim/altslider') ? 'current_section' : '' }}" title="Alt Slider">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">theaters</i></span>
                    <span class="menu_title">Alt Sliderlar</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/altsliderlar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.altslider.ekle') }}">Yeni Alt Slider</a></li>
                    <li class="{{ request()->is('yonetim/altsliderlar/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.altslider.listele') }}">Alt Sliderlar</a></li>
                </ul>
            </li>
            <li id="yorum-ayarlari" title="Yorum Ayarlari">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">chat</i></span>
                    <span class="menu_title">Yorum Ayarları</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/yorumlar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.yorum.ekle') }}">Yorum Ekle</a></li>
                    <li class="{{ request()->is('yonetim/yorumlar/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.yorum.listele') }}">Yorumları (Onayla / Sil)</a></li>
                </ul>
            </li>
            <li id="dosyalar" class="{{ request()->is('yonetim/dosyalar') ? 'current_section' : '' }}" title="Dosyalar">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">folder</i></span>
                    <span class="menu_title">Dosyalar</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/dosyalar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.dosya.yonetimi') }}">Resimler (jpg, png)</a></li>
                    <li class="{{ request()->is('yonetim/dosyalar/ekstra') ? 'act_item' : '' }}"><a href="{{ route('yonetim.dosya.ekstra') }}">Sunumlar (pdf)</a></li>
                </ul>
            </li>
            <li id="listeler" title="Listeler">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">settings_ethernet</i></span>
                    <span class="menu_title">Listeler (Sortable)</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/sortable/sayfalar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.sortable.sayfalar') }}">Menü Sıra Ayarları</a></li>
                    <li class="{{ request()->is('yonetim/sortable/urunler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.sortable.urunler') }}">Ürün Sıra Ayarları (Hepsi)</a></li>
                    <li class="{{ request()->is('yonetim/sortable/sec') ? 'act_item' : '' }}"><a href="{{ route('yonetim.sortable.sec') }}">Ürün Sıra Ayarları (Seçerek)</a></li>
                    <li class="{{ request()->is('yonetim/sortable/slider') ? 'act_item' : '' }}"><a href="{{ route('yonetim.sortable.slider') }}">Slider Sıra Ayarları</a></li>
                </ul>
            </li>
            <li id="gorunum-ayarlari" title="Görünüm Ayarları">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">visibility</i></span>
                    <span class="menu_title">Görünüm Ayarları</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/gorunumler/sayfalar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.gorunum.sayfalar') }}">Sayfalar Görünüm Ayarları</a></li>
                    <li class="{{ request()->is('yonetim/gorunumler/urunler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.gorunum.urunler') }}">Ürünler Görünüm Ayarları</a></li>
                    <li class="{{ request()->is('yonetim/gorunumler/slider') ? 'act_item' : '' }}"><a href="{{ route('yonetim.gorunum.slider') }}">Slider Görünüm Ayarları</a></li>
                </ul>
            </li>
            <li id="genel-ayarlar" title="Genel Ayarlar">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">build</i></span>
                    <span class="menu_title">Genel Ayarlar</span>
                </a>
                <ul>
                    <li><a href="{{ route('yonetim.anasayfa') }}">Seo Ayarları</a></li>
                    <li><a href="{{ route('yonetim.anasayfa') }}">Sosyal Medya Ayarları</a></li>
                    <li><a href="{{ route('yonetim.anasayfa') }}">Mail Ayarları</a></li>
                    <li><a href="{{ route('yonetim.anasayfa') }}">Tema Ayarları</a></li>
                </ul>
            </li>
            <li id="uye-bilgileri" title="Yönetici Ayarları">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">group-add</i></span>
                    <span class="menu_title">Yönetici Ayarları</span>
                </a>
                <ul>
                    <li class="{{ request()->is('yonetim/uye/ekle') ? 'act_item' : '' }}"><a href="{{ route('yonetim.uye.ekle') }}">Üye Ekle</a></li>
                    <li class="{{ request()->is('yonetim/uye/listele') ? 'act_item' : '' }}"><a href="{{ route('yonetim.uye.listele') }}">Üyeler</a></li>
                    <li class="{{ request()->is('yonetim/uye/yonetici') ? 'act_item' : '' }}"><a href="{{ route('yonetim.yonetici.ekle') }}">Yönetici Ekle</a></li>
                    <li class="{{ request()->is('yonetim/uye/yoneticiler') ? 'act_item' : '' }}"><a href="{{ route('yonetim.yonetici.listele') }}">Yöneticiler</a></li>
                    <li class="{{ request()->is('yonetim/uye/ayarlar') ? 'act_item' : '' }}"><a href="{{ route('yonetim.yonetici.ayarlar') }}">Şifre ve Giriş Bilgileri</a></li>
                </ul>
            </li>
            <li id="ajanda" class="{{ request()->is('yonetim/ajanda') ? 'current_section' : '' }}" title="Ajanda">
                <a href="{{ route('yonetim.takvim.takvim') }}">
                    <span class="menu_icon"><i class="material-icons">alarm</i></span>
                    <span class="menu_title">Ajanda</span>
                </a>
            </li>
        </ul>
    </div>
</aside>