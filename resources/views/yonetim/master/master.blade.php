<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ config('app.url').'admin/' }}assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ config('app.url').'admin/' }}assets/img/favicon-32x32.png" sizes="32x32">

    <title>{{ config('app.name') }}</title>

    <!-- additional styles for plugins -->
    <!-- weather icons -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}bower_components/weather-icons/css/weather-icons.min.css" media="all">
    <!-- metrics graphics (charts) -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}bower_components/metrics-graphics/dist/metricsgraphics.css">
    <!-- chartist -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}bower_components/chartist/dist/chartist.min.css">

    <!-- uikit -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}assets/css/main.min.css" media="all">

    <!-- sweet alert -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}swal2/sweetalert2.min.css">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
    <script type="text/javascript" src="{{ config('app.url').'admin/' }}bower_components/matchMedia/matchMedia.js"></script>
    <script type="text/javascript" src="{{ config('app.url').'admin/' }}bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

    @yield('css')

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

<!-- main header -->
@include('yonetim.master.partials.header')
<!-- main header end -->

<!-- main sidebar -->
@include('yonetim.master.partials.sidebar')
<!-- main sidebar end -->

<div id="page_content">
    @if (count($errors) > 0)
        <div class="md-card-content in-content">
            <div class="uk-alert uk-alert-danger" data-uk-alert>
                <a href="#" class="uk-alert-close uk-close"></a>
                <h4>İşlem gerçekleştirilemedi!</h4>
            </div>
        </div>
    @endif
    @yield('content')
</div>
<!-- common functions -->
<script src="{{ config('app.url').'admin/' }}assets/js/common.min.js"></script>
<!-- uikit functions -->
<script src="{{ config('app.url').'admin/' }}assets/js/uikit_custom.min.js"></script>
<!-- altair common functions/helpers -->
<script src="{{ config('app.url').'admin/' }}assets/js/altair_admin_common.min.js"></script>
<!-- sweet alert -->
<script src="{{ config('app.url').'admin/' }}swal2/sweetalert2.min.js"></script>

<script>
    function ToSeoUrl(textString) {

        textString = textString.replace(/ /g, "-");
        textString = textString.replace(/</g, "");
        textString = textString.replace(/>/g, "");
        textString = textString.replace(/"/g, "");
        textString = textString.replace(/é/g, "");
        textString = textString.replace(/!/g, "");
        textString = textString.replace(/'/, "");
        textString = textString.replace(/£/, "");
        textString = textString.replace(/^/, "");
        textString = textString.replace(/#/, "");
        textString = textString.replace(/$/, "");
        textString = textString.replace(/\+/g, "");
        textString = textString.replace(/%/g, "");
        textString = textString.replace(/½/g, "");
        textString = textString.replace(/&/g, "");
        textString = textString.replace(/\//g, "");
        textString = textString.replace(/{/g, "");
        textString = textString.replace(/\(/g, "");
        textString = textString.replace(/\[/g, "");
        textString = textString.replace(/\)/g, "");
        textString = textString.replace(/]/g, "");
        textString = textString.replace(/=/g, "");
        textString = textString.replace(/}/g, "");
        textString = textString.replace(/\?/g, "");
        textString = textString.replace(/\*/g, "");
        textString = textString.replace(/@/g, "");
        textString = textString.replace(/€/g, "");
        textString = textString.replace(/~/g, "");
        textString = textString.replace(/æ/g, "");
        textString = textString.replace(/ß/g, "");
        textString = textString.replace(/;/g, "");
        textString = textString.replace(/,/g, "");
        textString = textString.replace(/`/g, "");
        textString = textString.replace(/|/g, "");
        textString = textString.replace(/\./g, "");
        textString = textString.replace(/:/g, "");
        textString = textString.replace(/İ/g, "i");
        textString = textString.replace(/I/g, "i");
        textString = textString.replace(/ı/g, "i");
        textString = textString.replace(/ğ/g, "g");
        textString = textString.replace(/Ğ/g, "g");
        textString = textString.replace(/ü/g, "u");
        textString = textString.replace(/Ü/g, "u");
        textString = textString.replace(/ş/g, "s");
        textString = textString.replace(/Ş/g, "s");
        textString = textString.replace(/ö/g, "o");
        textString = textString.replace(/Ö/g, "o");
        textString = textString.replace(/ç/g, "c");
        textString = textString.replace(/Ç/g, "c");
        textString = textString.replace(/--/g, "-");
        textString = textString.replace(/---/g, "-");
        textString = textString.replace(/----/g, "-");
        textString = textString.replace(/----/g, "-");

        return textString.toLowerCase();
    }
</script>

@if ( session('mesaj_tur') != NULL )
<script>
    // custom callback
    function notify_callback() {
        return alert('Notify closed!');
    }

    function executeCallback(callback) {
        window[callback]();
    }

    function showNotify($element) {
        thisNotify = UIkit.notify({
            message: '{{ session('mesaj') }}',
            status: '{{ session('status') }}',
            timeout: 5000,
            group: '{{ session('group') }}',
            pos: '{{ session('pos') }}',
            onClose: function() {
                $body.find('.md-fab-wrapper').css('margin-bottom','');
                // clear notify timeout (sometimes callback fired more than once)
                clearTimeout(thisNotify.timeout)
            }
        });
        if(
            (
                ($window.width() < 768)
                && (
                    (thisNotify.options.pos == 'bottom-right')
                    || (thisNotify.options.pos == 'bottom-left')
                    || (thisNotify.options.pos == 'bottom-center')
                )
            )
            || (thisNotify.options.pos == 'bottom-right')
        ) {
            var thisNotify_height = $(thisNotify.element).outerHeight();
            var spacer = $window.width() < 768 ? -6 : 8;
            $body.find('.md-fab-wrapper').css('margin-bottom',thisNotify_height + spacer);
        }
    }

    $(function() {
        // notifications
        altair_notifications.init();
    });

    altair_notifications = {
        init: function() {
            setTimeout(function() {
                showNotify(["{{ session('mesaj_tur') }}"])
            },450)
        }
    };
</script>
@endif
<script>
@php
    $menuler = \App\Models\AdminMenu::where('visible', 0)->get();
    foreach ($menuler as $menu)
    {
        echo '$(".menu_all").find("li#'.$menu->slug.'").remove();';
    }
@endphp
</script>
@yield('javascript')
</body>
</html>