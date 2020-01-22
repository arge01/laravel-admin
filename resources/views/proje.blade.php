@extends('master.master')
@section('title', config('ayarlar.baslik').' | '.$gelen->slug)
@section('content')
    <div style="padding-top: 30px" id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="title">{{ $gelen->kategorisi->name }}</h4>
                    <div class="labels">
                        {{ $gelen->name }}
                    </div>
                    <div class="content-text">
                        @if( $gelen->icerik != NULL )
                            {!! $gelen->icerik !!}
                        @endif
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="col-md-4">
                    <div class="full-img">
                        <div class="img"><img src="{{ config('app.url') }}images/{{ $gelen->img }}" alt=""></div>
                        <div class="img-back"></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- and content -->
    @if(count($gelen->galerisi) > 0)
        <div id="new-product">
            <div class="container">
                <div class="row">
                    <div class="new-list-title new-pr-label">
                        <h4 class="new-pr-title">{{ $gelen->name }}</h4>
                    </div>
                    <div class="new-list-title new-pr-link">
                        <a href="{{ route('kategori', $gelen->kategorisi->slug) }}">{{ $gelen->kategorisi->name }} <i class="fa fa-angle-double-left"></i></a>
                    </div>
                    <div class="clear"></div>
                    <div class="new-pr-item">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="new-pr-left">
                                    <div class="new-pr-date">{{ date('m-d-Y', strtotime($gelen->olusturma_tarihi)) }}</div>
                                    <div class="new-pr-left-title">{{ $gelen->name }}</div>
                                    <div class="new-pr-left-p">
                                        {!! $gelen->label !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 new-pr-right">
                                <div class="row">
                                    <ul class="new-pr-items-ul">
                                        @foreach ( $gelen->galerisi as $i => $galeri )
                                            <li class="col-md-6">
                                                <a>
                                                    <div style="background-image: url({{ config('app.url') }}images/{{ $galeri->img }})" class="img-new-pr"></div>
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
@endsection
@section('javascript')
    <script>
        $('#navbar ul li#menu-2').addClass('active');
    </script>
    <script>
        $(".new-pr-items-ul").slick({
            dots: true,
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 2,
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
    </script>
@endsection