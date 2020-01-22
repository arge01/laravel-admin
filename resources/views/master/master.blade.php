<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('title', config('ayarlar.baslik'))</title>
    <meta name="description" content="{{ config('ayarlar.description') }}">
    <meta name="keywords" content="{{ config('ayarlar.keywords') }}">
    <meta name="author" content="{{ config('ayarlar.author') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"
    >
    @yield('css')
    <!-- Bootstrap -->
    <link href="{{ config('app.url') }}css/bootstrap.min.css" rel="stylesheet">
    <!--drop down-->
    <link rel="stylesheet" href="{{ config('app.url') }}css/dropdown.css">
    <!-- carousel -->
    <!-- slick banner -->
    <link rel="stylesheet" type="text/css" href="{{ config('app.url') }}slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{ config('app.url') }}slick/slick-theme.css">
    <!-- slick banner -->
    <link type="text/css" rel="stylesheet" href="{{ config('app.url') }}carousel/carousel.css">
    <!--style editor-->
    <link href="{{ config('app.url') }}css/reset.css" rel="stylesheet" type="text/css">
    <link href="{{ config('app.url') }}css/style.css" rel="stylesheet" type="text/css">
    <!--ui editor-->
    <link href="{{ config('app.url') }}js/ui/jquery-ui.css" rel="stylesheet">
    <!--ui editor-->
    @yield('importCss')
</head>
<body>
<section class="{{ request()->is('/') || request()->is('index.html') ? '' : 'half-slider' }} lazy" id="slider">
    @foreach($slider as $i => $slide)
        <div style="background-image: url({{ config('app.url').'images/'.$slide->img }})" class="slider-item">
            <div class="slider-gradient"></div>
        </div><!-- slider-item {{ $i }} -->
    @endforeach
</section><!-- end-slider -->
<section id="responsive-naw">
    <a href="{{ route('anasayfa') }}" class="logo"><img src="{{ config('app.url').'img/'.'logo.png' }}"></a>
    <div class="open-close-nav open-nav"><i class="fa fa-align-right"></i></div>
    <ul class="popup-nav">
        @foreach($menuler as $i => $menu)
        <li id="{{ 'res-menu-'.$menu->id }}" class="{{ request()->is($menu->slug.'.html') ? 'active' : '' }} {{ $menu->slug }}"><a target="{{ $menu->target }}" href="{{ $menu->url == NULL ? route('icerik', $menu->slug) : $menu->url }}">{!! $menu->name !!}</a></li>
        @endforeach
    </ul>
    <div class="close-nav"><i class="fa fa-angle-right"></i></div>
</section><!-- responsive-naw -->
<div class="col-center">
    <section id="nawbar">
        <div id="naw-rel">
            <div id="header">
                <ul>
                    @foreach($menuler as $i => $menu)
                    <li style="position: relative" id="{{ 'menu-'.$menu->id }}" class="{{ request()->is($menu->slug.'.html') ? 'active' : '' }} {{ $menu->slug }}">
                        <a 
                            target="{{ $menu->target }}" 
                            href="{{ $menu->url == NULL ? route('icerik', $menu->slug) : $menu->url }}"
                            class="{{ count($menu->tablari) > 0 ? 'dropdown-toggle' : '' }}"
                            >
                        {!! $menu->name !!}
                        </a>
                    
                    </li>
                    @endforeach
                </ul>
            </div><!-- and header -->
        </div>
    </section><!-- end nawbar -->
</div>
@yield('content')
@include('master.footer')
</body>
<script src="{{ config('app.url') }}js/jquery-1.11.3.min.js"></script>
<script src="{{ config('app.url') }}js/bootstrap.min.js"></script>
<script src="{{ config('app.url') }}js/scroll.js"></script>
<script src="{{ config('app.url') }}js/dropdown.js"></script>
<script src="{{ config('app.url') }}slick/slick.js"></script>
<script type="text/javascript">
    $(document).on('ready', function (keyframes, options) {
        $('.popup-nav').animate({'right': '-75%'});
        $('.open-nav').on('click', function() {
            $('.popup-nav').animate({'right': '0'});
            $('.close-nav').show();    
        });
        $('.close-nav').on('click', function() {
            $('.popup-nav').animate({'right': '-75%'});
            $(this).hide();

        });
        $('#page-top').on('click', function () {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });
        var sInfo = $('.slider-info').height();
        var slide = $('#slider').height();
        var newHeight = (slide - sInfo) / 2;
        $('.slider-info').css({'margin-top':  newHeight + 'px'});

        $(window).resize(function (olcek) {
            sInfo = $('.slider-info').height();
            slide = $('#slider').height();
            newHeight = (slide - sInfo) / 2;
            $('.slider-info').css({'margin-top':  newHeight + 'px'});
        });
        $(window).resize();
        $(".reference").slick({
            dots: true,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1366,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        $(".lazy").slick({
            lazyLoad: 'ondemand', // ondemand progressive anticipated
            infinite: true,
            autoplay: true,
            speed: 700,
            fade: true,
            cssEase: 'linear',
        });
        $('.next-prew .next').on('click', function () {
            $( ".slider-bottom .slick-prev" ).trigger( "click" );
            return false;
        });
        $('.next-prew .prew').on('click', function () {
            $( ".slider-bottom .slick-next" ).trigger( "click" );
            return false;
        });
    });
</script>
@yield('javascript')
</html>