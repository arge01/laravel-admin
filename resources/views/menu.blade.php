@extends('master.master')
@section('title', config('ayarlar.baslik'). ' | '. $gelen->name)
@section('content')
    <section style="padding-top: 30px;" id="page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cont-page-item">
                        <div class="title">
                            {{ $gelen->name }}
                        </div>
                        <h5 class="alt-title">-</h5>
                    </div>
                    @if(count($gelen->tablari) > 0)
                        @foreach($gelen->tablari as $i => $tab)
                            <a href="{{route('menu', $tab->slug)}}" id="{{ $tab->slug }}" class="col-md-4 cont-page-items">
                                <div class="cont-text">
                                    <h1>{{$tab->name}}</h1>
                                    @if( $tab->icerigi != NULL )
                                        {!! $tab->icerigi->icerik !!}
                                        <div class="clear"></div>
                                    @endif
                                </div>
                                <div class="clear"></div>
                            </a> <!-- {{ $i }} -->
                        @endforeach
                    @else
                        <div class="cont-page-items">
                            <div class="cont-text">
                                @if( $gelen->icerigi != NULL )
                                    {!! $gelen->icerigi->icerik !!}
                                    <div class="clear"></div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div> <!-- {{ '1' }} -->
                    @endif
                </div>
            </div>
        </div>
    </section><!-- and content -->
    @if ( count($gelen->galerisi) > 0 )
    <div id="product">
        <div class="container">
            <div class="row">
                <div class="pr-list">
                    <div class="col-md-4 rol-left pr-title">GALERİ</div>
                </div>
            </div>
        </div><!-- and container -->
        <div class="pr-items">
            <ul class="ul-pr-item">
                @foreach($gelen->galerisi as $i => $resim)
                    <li style="margin-bottom: 30px;" class="col-md-3">
                        <a class="fancybox-thumbs" data-fancybox-group="thumb" href="{{ config('app.url').'images/'.$resim->img }}">
                            <div style="background: none" class="pr-hover"> + </div>
                            <div class="pr-img"><img src="{{ config('app.url') }}images/{{ $resim->img }}"></div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="clear"></div>
        </div><!-- and pr-items -->
    </div><!-- and product -->
    @endif
@endsection
@section('javascript')
    <script>
        ID = $('#navbar ul li.active').attr('id');
        newID = ID.split('-');
        inClass = newID[0] + '-' + newID[1];
        $('#navbar ul li#'+ inClass).addClass('active');
    </script>
    <!-- Add mousewheel plugin (this is optional) -->
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
@endsection