@extends('master.master')
@section('title', config('ayarlar.baslik'. '| ŞUBELERİMİZ'))
@section('content')
<div class="container">
	<section style="margin-bottom: 0px; padding-top: 25px" id="page">
		<div class="container">
			<div class="row">
                    <div class="col-md-12">

                            <div class="cont-page-item">
        
                                <div class="title">
        
                                    {{ $gelen->name }}
        
                                </div>
        
                                <h5 class="alt-title">-</h5>
        
                            </div>
                    </div>
				<div id="map" style="width: 100%; height: 600px;"></div>
			</div>
		</div>
	</section><!-- and section -->

    <section style="position: relative; z-index: 1" id="select-item">
        <div class="container">
            <div class="row">
                <h4 class="title">Şube Seçiniz:</h4>
                <div style="position: relative; z-index: 1000000000" class="relativediv-10000">
                    <div class="col-md-6">
                    <div class="row">
                        <div style="position: relative" class="form-group">
                            <select class="form-control select2-multiple" id="il">
                                <option value="0">İl Seçiniz</option>
                                @foreach ( $iller as $i => $il )
                                @if( count($il->subeleri) > 0 )
                                <option value="{{$il->id}}" id="{{'il-'.$il->id}}">{{$il->baslik}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="col-md-6">
                    <div class="row">
                        <div style="position: relative" class="form-group">
                            <select class="form-control select2-multiple" id="ilce">
                                <option value="0">İlçe Seçiniz</option>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div style="position: relative" class="form-group">
                            <select class="form-control n-form-control" id="selectsubeler">
                                <option value="0">Önce İl ve İlçe Seçiniz</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<section id="last-pr">
		@if( $gelen->icerigi != NULL )
		<div id="new-product">
			<div style="display: none" id="{{$gelen->slug}}" class="container news-sube">
				<div class="row">
					<div class="new-pr-item">
						<div class="row">
							<div class="col-md-4">
								<div class="new-pr-left">
									<div class="new-pr-date">{{ $gelen->name }}</div>
									<div class="new-pr-left-title">{{ $gelen->icerigi->name }}</div>
									<div class="new-pr-left-p">
										{!! $gelen->icerigi->icerik !!}
									</div>
								</div>
							</div>
							<div class="col-md-8 new-pr-right">
								<div class="row">
									<ul class="new-pr-items-ul">
										@foreach ( $gelen->galerisi as $i => $galeri )
											<li class="col-md-6">
												<a class="fancybox-buttons" data-fancybox-group="button" data-gallery="" href="{{config('app.url').'images/'.$galeri->img}}">
													<div style="background-image: url({{ config('app.url') }}images/thump-{{ $galeri->img }})" class="img-new-pr"></div>
												</a>
											</li>
										@endforeach
									</ul>
									<div class="clear"></div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div><!-- and new product -->
				</div>
			</div>
		</div><!-- and new-product -->
		@endif
		@foreach ( $gelen->tablari as $i => $tab )
		@if( $tab->icerigi != NULL )
		<div id="new-product">
				<div style="display: none" id="sube-{{$tab->id}}" class="container news-sube">
					<div class="row">
						<div class="new-pr-item">
							<div class="row">
								<div class="col-md-4">
									<div class="new-pr-left">
										<div class="new-pr-date">{{ $tab->name }}</div>
										<div class="new-pr-left-title">{{ $tab->icerigi->name }}</div>
										<div class="new-pr-left-p">
											{!! $tab->icerigi->icerik !!}
										</div>
									</div>
								</div>
								<div class="col-md-8 new-pr-right">
									<div class="row">
										<ul class="new-pr-items-ul">
											@foreach ( $tab->galerisi as $i => $galeri )
												<li class="col-md-6">
													<a class="fancybox-buttons" data-fancybox-group="button" data-gallery="" href="{{config('app.url').'images/'.$galeri->img}}">
														<div style="background-image: url({{ config('app.url') }}images/thump-{{ $galeri->img }})" class="img-new-pr"></div>
													</a>
												</li>
											@endforeach
										</ul>
										<div class="clear"></div>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div><!-- and new product -->
					</div>
				</div>
			</div><!-- and new-product -->
			@endif
		@endforeach
	</section><!-- end last-pr -->
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
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ config('app.url') }}css/blueimp-gallery.css">
<link rel="stylesheet" href="{{ config('app.url') }}css/blueimp-gallery-indicator.css">
<link rel="stylesheet" href="{{ config('app.url') }}css/blueimp-gallery-video.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="stylesheet" href="{{ config('app.url') }}select2/select2-bootstrap.css">
<style>
    .input-group-btn1 {
        position: absolute;
        top: 33px;
        right: 0;
    }
    .form-control:focus {outline: none;}
    .select2-container--bootstrap .select2-selection.form-control {
        border-radius: 0;
        box-shadow: none;
        border: 1px solid #4b5049;
        background: #e4e4e4;
        color: #fff;
    }
    .n-form-control {
        display: block;
        width: 100%;
        height: 50px !important;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #fff !important;
        background-color: #4b5049 !important;
        background-image: none;
        border: none !important;
        border-radius: 0 !important;
    }
</style>
@endsection
@section('javascript')
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAvw9khV9waiQA416RrEqMFw8h4X2QwkLs" type="text/javascript"></script>
<script type="text/javascript">
    var locations = [
	  ['{!! $gelen->icerigi->name."<br>ÇORUM / MERKEZ" !!}', {{$gelen->icerigi->label}}, 'sube-{{$gelen->id}}', 'ÇORUM / MERKEZ', '"ÇORUM / MERKEZ"'],
	  @foreach ( $gelen->tablari as $i => $tab )
	  @if( $tab->icerigi != NULL )
	    ['{!! $tab->icerigi->name !!}', {{$tab->icerigi->label}}, 'sube-{{$tab->id}}', '{{App\Http\Controllers\AnasayfaController::ililcegetir($tab->icerigi->il, $tab->icerigi->ilce)}}', '{{App\Http\Controllers\AnasayfaController::ililcegetir($tab->icerigi->il, $tab->icerigi->ilce) }}'],
	  @endif
	  @endforeach
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: new google.maps.LatLng(40.205957, 35.231625, 6),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      "elementType": "geometry",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8ec3b9"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1a3646"
      }
    ]
  },
  {
    "featureType": "administrative.country",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#4b6878"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#64779e"
      }
    ]
  },
  {
    "featureType": "administrative.neighborhood",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "administrative.province",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#4b6878"
      }
    ]
  },
  {
    "featureType": "landscape.man_made",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#334e87"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#283d6a"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#6f9ba5"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#3C7680"
      }
    ]
  },
  {
    "featureType": "road",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#304a7d"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#98a5be"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#2c6675"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#255763"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#b0d5ce"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#98a5be"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#283d6a"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#3a4762"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#0e1626"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#4e6d70"
      }
    ]
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    
    /*for (i = 0; i < locations.length; i++) {  
       var infowindow = new google.maps.InfoWindow();
       marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map
       });
       infowindow.setContent(locations[i][0]);
       infowindow.open(map, marker);
    }*/

    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        title: locations[i][7].toString()+'\u200b',
      });
      google.maps.event.addListener(marker, (function(marker, i) {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
      })(marker, i));
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          title = infowindow.setContent(locations[i][0]);
		  infowindow.open(map, marker);
		  $('.news-sube:visible').hide();
		  $('#'+locations[i][5]+':hidden').show();
		  $('html, body').stop().animate({
			scrollTop: $('#'+locations[i][5]).offset().top
		  }, 1000);
        }
      })(marker, i));
      google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
         return function() {
          infowindow.setContent(locations[i][0]);
		  infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
  <script>
    $('#il').on('change', function(){
        $('#ilce').html("");
        $('#selectsubeler').html("");
        $('#selectsubeler').append(
            '<option value="0">Önce İl ve İlçe Seçiniz..</option>'
        );
        $('#ilce').append(
            '<option value="0">Lütfen Bekleyiniz..</option>'
        );
        $.ajax({
            type: "POST",
            url: "{{route('ajax.city')}}",
            data: { data: $(this).find('option:selected').val() },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(data){
                $('#ilce').html("");
                $('#ilce').append(
                    '<option value="0">İlçe Seçiniz</option>'
                );
                $.each( data, function( key, value ) {
                    if(value.subeleri != "") {
                        $('#ilce').append(
                            '<option value="'+value.id+'">'+value.baslik+'</option>'
                        );
                    }
                });
            }
        });
    });
    $('#ilce').on('change', function(){
        $('#selectsubeler').html("");
        $('#selectsubeler').append(
            '<option value="0">Lütfen Bekleyiniz..</option>'
        );
        $.ajax({
            type: "POST",
            url: "{{route('ajax.branch')}}",
            data: { 
                il: $('#il').find('option:selected').val(),
                ilce: $(this).find('option:selected').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(data){
                $('#selectsubeler').html("");
                $('#selectsubeler').append(
                    '<option value="0">'+$('#il').find('option:selected').text()+ ' / ' +$('#ilce').find('option:selected').text()+ ' Şubelerimizi Seçiniz' +'</option>'
                );
                $('.news-sube:visible').hide();
                $.each( data, function( key, value ) {
                    $('#sube-' + value.sayfa.id + ':hidden').show();
                    $('#selectsubeler').append(
                        '<option value="sube-'+value.sayfa.id+'">'+value.name+'</option>'
                    );
                });
            }
        });
    });
    $('#selectsubeler').on('change', function() {
        $('.news-sube:visible').hide();
        $('#'+$(this).find('option:selected').val()+':hidden').show();
        $('html, body').stop().animate({
        scrollTop: $('#'+$(this).find('option:selected').val()).offset().top
        }, 1000);
    });
    $( ".select2-single, .select2-multiple" ).select2( {
		theme: "bootstrap",
		placeholder: "Select a State",
		maximumSelectionSize: 6,
		containerCssClass: ':all:'
    } );
    $( "button[data-select2-open]" ).click( function() {
        $( "#" + $( this ).data( "select2-open" ) ).select2( "open" );
    });
        $(".new-pr-items-ul").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
            autoplay: true,
            // ■ //
            responsive: [
                {
                    breakpoint: 1366,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
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
        $(".e-shopper").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            // ■ //
            responsive: [
                {
                    breakpoint: 1368,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
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
        $(".ul-pr-item").slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            // ■ //
            responsive: [
                {
                    breakpoint: 1368,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
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
	</script>
	<script src="{{ config('app.url') }}js/blueimp-helper.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-fullscreen.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-indicator.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-video.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-vimeo.js"></script>
    <script src="{{ config('app.url') }}js/blueimp-gallery-youtube.js"></script>
    <script src="{{ config('app.url') }}js/jquery.blueimp-gallery.js"></script>
@endsection