@extends('master.master')
@section('title', config('ayarlar.baslik') . ' | ' . $gelen->name)
@section('content')
    <div style="padding-top: 30px" id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="full-img">
                        <div class="img"><img src="{{ config('app.url') }}images/{{ 'thump-'.$gelen->img }}" alt=""></div>
                        <div class="img-back"></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- and content -->
@endsection