@extends('master.master')
@section('title', config('ayarlar.baslik') . ' | ' . $title)
@section('content')
    <!-- content -->
    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <p>
            <span style="position: relative; top: 3px; font-size: 2.1em">{</span> 
            <a href="{{route('sayfalar', 'iletisim')}}"><i class="fas fa-layer-group"></i></a> Developer By 
            <span class="font-weight-bold text-light bg-dark p-1">Arif GEVENCI</span>
            <span style="position: relative; top: 3px; font-size: 2.1em">}</span>
        </p>
    </main>
    <!-- content -->
@endsection
@section('css')
    <!-- extend css -->
    
    <!--extend css -->
@endsection
@section('javascript')
    <!-- extend js -->
    
    <!-- extend js -->
@endsection