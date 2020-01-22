@extends('master.master')

@section('title', config('ayarlar.baslik'). ' | '. $gelen->name)

@section('content')

    <section style="padding-top: 30px;" id="page">

        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    <div class="cont-page-item">

                        <div class="title">

                            {!! $gelen->name !!}

                        </div>

                        <h5 class="alt-title">-</h5>

                    </div>

                    @if($gelen->icerigi != NULL)
                    @if($gelen->icerigi->label != null)
                    <div id="map" style="width: 100%; height: 600px;"></div>
                    @endif
                    @endif

                    @if(count($gelen->tablari) > 0)

                        @foreach($gelen->tablari as $i => $tab)
                        
                            <h5 class="c-title">{{$tab->icerigi->name}}</h5>

                            <div id="{{ $tab->slug }}" class="cont-page-items">

                                <div class="cont-text">

                                    @if( $tab->icerigi != NULL )

                                        {!! $tab->icerigi->icerik !!}

                                        <div class="clear"></div>

                                    @endif

                                </div>

                                <div class="clear"></div>

                            </div> <!-- {{ $i }} -->
                        </div>
                        </div>
                        </div>
                            
                            @if ( !empty($tab->galerisi) )
    
                            <section id="gal">
                                @foreach ( $tab->galerisi as $i => $gal )
                                <div class="col-gal col-md-3">
                                    <div class="row">
                                        <a data-gallery="" href="{{config('app.url').'images/'.$gal->img}}">
                                            <img src="{{config('app.url').'images/thump-'.$gal->img}}">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </section>
                            <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a style="display: block" class="prev">‹</a>
                                <a style="display: block" class="next">›</a>
                                <a style="display: block" class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>
                            @endif

                        @endforeach

                    @else
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

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

    @if ( !empty($gelen->galerisi) )
    
    <section id="gal">
        @foreach ( $gelen->galerisi as $i => $gal )
        <div class="col-gal col-md-3">
            <div class="row">
                <a data-gallery="" href="{{config('app.url').'images/'.$gal->img}}">
                    <img src="{{config('app.url').'images/thump-'.$gal->img}}">
                </a>
            </div>
        </div>
        @endforeach
    </section>
    <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a style="display: block" class="prev">‹</a>
        <a style="display: block" class="next">›</a>
        <a style="display: block" class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    @endif

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
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
@if($gelen->icerigi != NULL)
@if($gelen->icerigi->label != null)
<script type="text/javascript">
    var locations = [
	  ['{{$gelen->icerigi->name}}', {{$gelen->icerigi->label}}, '{{$gelen->slug}}'],
	  @foreach ( $gelen->tablari as $i => $tab )
	  @if( $tab->icerigi != NULL )
	  ['{{$tab->icerigi->name}}', {{$tab->icerigi->label}}, '{{$tab->slug}}'],
	  @endif
	  @endforeach
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 5,
      center: new google.maps.LatLng(39.635791, 33.2316247, 6.75),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, (function(marker, i) {
        
          infowindow.setContent(locations[0][0]);
          infowindow.open(map, marker);
        
      })(marker, i));

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
		  infowindow.open(map, marker);
		  $('.news-sube:visible').hide();
		  $('#'+locations[i][5]+':hidden').show();
		  $('html, body').stop().animate({
			scrollTop: $('#'+locations[i][5]).offset().top
		  }, 1000);
        }
      })(marker, i));
    }
  </script>
  @endif
  @endif

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