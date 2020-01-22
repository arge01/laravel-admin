<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="{{ config('app.url').'admin/' }}assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ config('app.url').'admin/' }}assets/img/favicon-32x32.png" sizes="32x32">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">

    <!-- uikit -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}bower_components/uikit/css/uikit.almost-flat.min.css"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}assets/css/login_page.min.css" />

    <!-- sweet alert -->
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}swal2/sweetalert2.min.css">

</head>
<body class="login_page">

<div class="login_page_wrapper">
    <div class="md-card" id="login_card">
        <div class="md-card-content large-padding" id="login_form">
            <div class="login_heading">
                <div class="user_avatar"></div>
            </div>
            <form action="{{ route('yonetim.oturumac') }}" method="post">
                {{ csrf_field() }}
                <div class="uk-form-row">
                    <label for="login_username">Kullanıcı Adı *</label>
                    <input required class="md-input" type="text" id="login_username" name="email" />
                </div>
                <div class="uk-form-row">
                    <label for="login_password">Şifre *</label>
                    <input required class="md-input" type="password" id="login_password" name="sifre" />
                </div>
                <div class="uk-margin-medium-top">
                    <button class="md-btn md-btn-primary md-btn-block md-btn-large">Giriş Yap</button>
                </div>
                <div class="uk-margin-top">
                    <a href="#" id="login_help_show" class="uk-float-right">Bilgi</a>
                    <span class="icheck-inline">
                            <input checked type="checkbox" name="benihatirla" id="login_page_stay_signed" data-md-icheck />
                            <label for="login_page_stay_signed" class="inline-label">Beni Hatırla</label>
                        </span>
                </div>
            </form>
        </div>
        <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
            <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
            <h2 class="heading_b uk-text-success">Bu panel</h2>
            
        </div>
    </div>
    
</div>

<!-- common functions -->
<script src="{{ config('app.url').'admin/' }}assets/js/common.min.js"></script>
<!-- altair core functions -->
<script src="{{ config('app.url').'admin/' }}assets/js/altair_admin_common.min.js"></script>
<!-- altair login page functions -->
<script src="{{ config('app.url').'admin/' }}assets/js/pages/login.min.js"></script>
<!-- sweet alert -->
<script src="{{ config('app.url').'admin/' }}swal2/sweetalert2.min.js"></script>
<script>
    @if ( count($errors) > 0 )
    swal({
        type: 'error',
        title: 'Hata...',
        text: 'Lütfen giriş bilgilerinizi kontrol edip tekrar deneyiniz!',
        confirmButtonText: 'Tamam'
    });
    @endif
</script>

</body>
</html>