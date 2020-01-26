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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap-4.4.1 for Arif GEVENCI</title>
    <!-- bootstrap 4.4.1 -->
    <link rel="stylesheet" href="{{ config('app.url') }}css/bootstrap-4/bootstrap.min.css">
    <!-- fontawesome 5.12.0 -->
    <link href="{{ config('app.url') }}css/fontawesome-5.12/css/all.min.css" rel="stylesheet">
    <!-- reset css -->
    <link rel="stylesheet" href="{{ config('app.url') }}css/reset-css/standardized.min.css">
    <link rel="stylesheet" href="{{ config('app.url') }}css/reset-css/normalize.min.css">
    <link rel="stylesheet" href="{{ config('app.url') }}css/reset-css/formalize.min.css">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,700,800&display=swap&subset=latin-ext" rel="stylesheet">
    <!-- style responsive css -->
    <link rel="stylesheet" href="{{config('app.url')}}css/style.css">
    @yield('css')
</head>
<body>
    @include('master.navbar')
    @yield('content')
    @include('master.footer')
</body>
<!-- jquery 3.4.1 -->
<script src="{{ config('app.url') }}js/jquery-3.4.1.min.js"></script>
<!-- popper 1.16.0 -->
<script src="{{ config('app.url') }}js/popper.min.js"></script>
<!-- bootstrap 4.4.1 -->
<script src="{{ config('app.url') }}js/bootstrap-4/bootstrap.min.js"></script>
<!-- fontawesome 5.12.0 -->
<script src="{{ config('app.url') }}js/bootstrap-4/bootstrap.min.js"></script>
<!-- javascript -->
<script src="{{ config('app.url') }}css/fontawesome-5.12/js/all.min.js"></script>
@yield('javascript')
</html>