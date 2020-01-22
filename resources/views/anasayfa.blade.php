@extends('master.master')
@section('title', config('ayarlar.baslik'))
@section('content')

    <div id="myModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <a href="{{route('franchise')}}">
                    <img style="width: 100%; height: auto" src="{{config('app.url').'images/popup.jpg'}}" alt="">
                </a>
            </div>
          </div>
        </div>
    </div>    

    <section style="background-image: url({{ config('app.url').'images/'.$kurumsalIMG->img }})" id="start-section">
        <div class="container">
            <div class="row">
                <div class="center-col-800 col-st col-md-6">
                    <h1>{!!$kurumsal->name!!}</h1>
                    {!! $kurumsal->icerik !!}
                </div>
                <div class="center-col-800 col-bg col-md-6"></div>
            </div>
        </div>
    </section>

    <section id="gal">
        <!--
        @foreach ( $galeri as $i => $gal )
        <div class="col-gal col-md-3">
            <div class="row">
                <a class="fancybox-buttons" data-fancybox-group="button" data-gallery="" href="{{config('app.url').'images/'.$gal->img}}">
                    <img src="{{config('app.url').'images/thump-'.$gal->img}}">
                </a>
            </div>
        </div>
        @endforeach
        -->
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
    <script>
        $('#myModal').modal('show');
    </script>
    <script>
    var token = '897912977.1677ed0.ddebc91b0b084495b71a62431a9a4fd5',
        num_photos = 12;
     
    $.ajax({
    	url: 'https://api.instagram.com/v1/users/self/media/recent',
    	dataType: 'jsonp',
    	type: 'GET',
    	data: {access_token: token, count: num_photos},
    	success: function(data){
    	    console.log(data);
    		for( x in data.data ){
    			$('#gal').append('<div class="col-gal col-md-3"><div class="mega-ins"><span> '+data.data[x].likes.count+'<i class="fa fa-heart" aria-hidden="true"></i></span> <a target="_blank" href="'+data.data[x].link+'"><i class="fa fa-link" aria-hidden="true"></i></a> <a class="fancybox-buttons" data-fancybox-group="button" data-gallery="" href="'+data.data[x].images.standard_resolution.url+'"><i class="fa fa-plus" aria-hidden="true"></i></a> </div><div class="row"><a href="'+data.data[x].images.standard_resolution.url+'"><img src="'+data.data[x].images.low_resolution.url+'"></a></div></div>');
    		}
    	},
    	error: function(data){
    		console.log(data);
    	}
    });
    </script>
@endsection