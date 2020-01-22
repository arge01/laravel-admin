@extends('master.master')

@section('title', config('ayarlar.baslik'). ' | '. $gelen->name)
@section('content')

    @if ( count($gelen->galerisi) > 0 )

    <section id="menu-slider" class="owl-carousel">

    @foreach($gelen->galerisi as $i => $resim)  
        <div class="slider-item">
            <img src="{{ config('app.url') }}images/{{ $resim->img }}">
            <a class="slide-text fancybox-thumbs" data-fancybox-group="thumb" href="{{ config('app.url').'images/'.$resim->img }}"></a>
        </div><!-- slider-item 2 -->
    @endforeach
    </section><!-- and slider -->

    @endif

@endsection
@section('importCss')
<style>
        .fancybox-overlay-fixed {
            position: fixed;
            bottom: 0;
            right: 0;
            z-index: 1000000000000;
        }
.half-slider {
    height: 110px !important;
    min-height: 110px !important;
    overflow: hidden;
}
#footer {
    margin-top: 0px !important
}
#responsive-naw {
    display: block;
    background: none;
    top: 0;
    background: #4b5049 !important;
}
.blueimp-gallery {z-index: 100000000000000}
</style>
@endsection

@section('css')
<!-- Owl Stylesheets -->
<link rel="stylesheet" href="{{config('app.url')}}owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="{{config('app.url')}}owlcarousel/css/owl.theme.default.min.css">
<link rel="stylesheet" href="{{config('app.url')}}owlcarousel/css/owl.animate.css">
<style>
#menu-slider {
    width: 100%;
    height: auto;
    background: #ddd;
    cursor: e-resize;
    overflow: hidden;
}
#menu-slider .slider-item {
    width: 100%;
    height: auto;
    display: flex;
    flex-direction: row;
    align-items: center;
    position: relative;
}
#menu-slider .slider-item img {
    width: 100%;
    height: auto;
    display: flex;
    position: relative;
    z-index: 1;
}
#menu-slider .slider-item .slider-gradient {
    width: 100%;
    height: 100%;
    display: flex;
    background: #000;
    position: absolute;
    z-index: 10;
    top: 0;
    left: 0;
    opacity: .4;
}
#menu-slider .slide-text {
    width: 100%;
    height: 100%;
    flex: 1;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
}
#menu-slider .slide-text-center {
    height: 100%;
    justify-content: left;
    position: relative;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}
#menu-slider .slide-text-center {color: #fff}
#menu-slider .slide-text-center h1 {margin-bottom: 5px;font-size: 2.2em;}
#menu-slider .slide-text-center span {line-height: 125%;font-size: 12pt;font-weight: 300;margin-bottom: 15px;}
#menu-slider .slide-text-center a {color: #292929;background: #ffffff;padding: 5px 10px;font-size: 12pt;font-weight: 700;}
#menu-slider .slide-text-center a:hover {background: #3d4f9a;color: #fff;}
</style>
@endsection

@section('javascript')
    <script src="{{config('app.url')}}owlcarousel/js/owl.carousel.min.js"></script>

    <script type="text/javascript" src="{{ config('app.url') }}lightbox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox main JS and CSS files -->

    <script type="text/javascript" src="{{ config('app.url') }}lightbox/source/jquery.fancybox.js?v=2.1.5"></script>

    <link rel="stylesheet" type="text/css" href="{{ config('app.url') }}lightbox/source/jquery.fancybox.css?v=2.1.5" media="screen"/>

    <!-- Add Button helper (this is optional) -->

    <link rel="stylesheet" type="text/css" href="{{ config('app.url') }}lightbox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5"/>

    <script type="text/javascript" src="{{ config('app.url') }}lightbox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->

    <link rel="stylesheet" type="text/css" href="{{ config('app.url') }}lightbox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7"/>

    <script type="text/javascript" src="{{ config('app.url') }}lightbox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <!-- Add Media helper (this is optional) -->

    <script type="text/javascript" src="{{ config('app.url') }}lightbox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            /*

             *  Simple image gallery. Uses default settings

             */



            $('.fancybox').fancybox();



            /*

             *  Different effects

             */



            // Change title type, overlay closing speed

            $(".fancybox-effects-a").fancybox({

                helpers: {

                    title: {

                        type: 'outside'

                    },

                    overlay: {

                        speedOut: 0

                    }

                }

            });



            // Disable opening and closing animations, change title type

            $(".fancybox-effects-b").fancybox({

                openEffect: 'none',

                closeEffect: 'none',



                helpers: {

                    title: {

                        type: 'over'

                    }

                }

            });



            // Set custom style, close if clicked, change title type and overlay color

            $(".fancybox-effects-c").fancybox({

                wrapCSS: 'fancybox-custom',

                closeClick: true,



                openEffect: 'none',



                helpers: {

                    title: {

                        type: 'inside'

                    },

                    overlay: {

                        css: {

                            'background': 'rgba(238,238,238,0.85)'

                        }

                    }

                }

            });



            // Remove padding, set opening and closing animations, close if clicked and disable overlay

            $(".fancybox-effects-d").fancybox({

                padding: 0,



                openEffect: 'elastic',

                openSpeed: 150,



                closeEffect: 'elastic',

                closeSpeed: 150,



                closeClick: true,



                helpers: {

                    overlay: null

                }

            });



            /*

             *  Button helper. Disable animations, hide close button, change title type and content

             */



            $('.fancybox-buttons').fancybox({

                openEffect: 'none',

                closeEffect: 'none',



                prevEffect: 'none',

                nextEffect: 'none',



                closeBtn: false,



                helpers: {

                    title: {

                        type: 'inside'

                    },

                    buttons: {}

                },



                afterLoad: function () {

                    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');

                }

            });





            /*

             *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked

             */



            $('.fancybox-thumbs').fancybox({

                prevEffect: 'none',

                nextEffect: 'none',



                closeBtn: false,

                arrows: false,

                nextClick: true,



                helpers: {

                    thumbs: {

                        width: 50,

                        height: 50

                    }

                }

            });



            /*

             *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.

            */

            $('.fancybox-media')

                .attr('rel', 'media-gallery')

                .fancybox({

                    openEffect: 'none',

                    closeEffect: 'none',

                    prevEffect: 'none',

                    nextEffect: 'none',



                    arrows: false,

                    helpers: {

                        media: {},

                        buttons: {}

                    }

                });



            /*

             *  Open manually

             */



            $("#fancybox-manual-a").click(function () {

                $.fancybox.open('1_b.jpg');

            });



            $("#fancybox-manual-b").click(function () {

                $.fancybox.open({

                    href: 'iframe.html',

                    type: 'iframe',

                    padding: 5

                });

            });



            $("#fancybox-manual-c").click(function () {

                $.fancybox.open([

                    {

                        href: '1_b.jpg',

                        title: 'My title'

                    }, {

                        href: '2_b.jpg',

                        title: '2nd title'

                    }, {

                        href: '3_b.jpg'

                    }

                ], {

                    helpers: {

                        thumbs: {

                            width: 75,

                            height: 50

                        }

                    }

                });

            });





        });

    </script>
<script>
    //slider
    $('.owl-carousel').owlCarousel({
        items: 1,
        autoHeight: true,
        loop: true,
        autoplay: true,
        autoplayTimeout: 50000, 
        dots: false
      });
      //slider

      function detectmob() {
        if( navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)
        ){
            return true;
        }
        else {
            return false;
        }
    }
    if ( detectmob() != true ) {
        window.location.href = "{{route('menu', $gelen->slug)}}";
    }
</script>
@endsection