@extends('master.master')
@section('title', config('ayarlar.baslik'). ' | '. 'ÜRÜNLERİMİZ')
@section('content')
    <div style="padding-top: 30px" id="product">
        <div class="container">
            <div class="row">
                <div class="pr-list">
                    <h4 class="col-md-4 rol-left pr-title">KATEGORİLER</h4>
                    <div class="col-md-8 rol-left pr-list">
                        <ul>
                            <li class="active"><a href="{{ route('projeler') }}">Tüm Ürünler</a></li>
                            @foreach($kategoriler as $i => $kategori)
                                <li><a href="{{ route('kategori', $kategori->slug) }}">{{ $kategori->name }}</a></li>
                            @endforeach
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div><!-- and container -->
        <div class="container">
            <div class="row">
                <div class="pr-items">
                    <ul class="ul-pr-item">
                        @foreach($projeler as $i => $proje)
                            <li style="margin-bottom: 30px" class="col-md-4">
                                <a class="fancybox-buttons" data-fancybox-group="button" href="{{ config('app.url').'images/resized/'.$proje->img }}" data-gallery>
                                    <div class="pr-hover"></div>
                                    <div class="pr-label">
                                        {{ $proje->name }}
                                        <p>
                                            {!! $proje->label !!}
                                        </p>
                                    </div>
                                    <div class="pr-img"><img src="{{ config('app.url') }}images/{{ $proje->img }}"></div>
                                </a>
                            </li>
                        @endforeach
                        <div class="clear"></div>
                    </ul>
                    <div class="clear"></div>
                </div><!-- and pr-items -->
            </div>
        </div>
    </div><!-- and product -->
    <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ config('app.url') }}css/blueimp-gallery.css">
<link rel="stylesheet" href="{{ config('app.url') }}css/blueimp-gallery-indicator.css">
<link rel="stylesheet" href="{{ config('app.url') }}css/blueimp-gallery-video.css">
@endsection
@section('javascript')
    <script src="{{ config('app.url') }}js/blueimp-helper.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-fullscreen.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-indicator.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-video.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-vimeo.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-youtube.js"></script>
    <script src="{{ config('app.url') }}js/jquery.blueimp-gallery.js"></script>
@endsection