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
    <style>
        {
            font-family: 'PT Sans Caption', sans-serif, 'arial', 'Times New Roman';
        }
        /* Error Page */
        .error .clip .shadow
        {
            height: 180px;  /*Contrall*/
        }
        .error .clip:nth-of-type(2) .shadow
        {
            width: 130px;   /*Contrall play with javascript*/
        }
        .error .clip:nth-of-type(1) .shadow, .error .clip:nth-of-type(3) .shadow
        {
            width: 250px; /*Contrall*/
        }
        .error .digit
        {
            width: 150px;   /*Contrall*/
            height: 150px;  /*Contrall*/
            line-height: 150px; /*Contrall*/
            font-size: 120px;
            font-weight: bold;
        }
        .error h2   /*Contrall*/
        {
            font-size: 32px;
        }
        .error .msg /*Contrall*/
        {
            top: -190px;
            left: 30%;
            width: 80px;
            height: 80px;
            line-height: 80px;
            font-size: 9pt;
        }
        .error span.triangle    /*Contrall*/
        {
            top: 70%;
            right: 0%;
            border-left: 20px solid #535353;
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
        }


        .error .container-error-404
        {
            margin-top: 10%;
            position: relative;
            height: 250px;
            padding-top: 40px;
        }
        .error .container-error-404 .clip
        {
            display: inline-block;
            transform: skew(-45deg);
        }
        .error .clip .shadow
        {

            overflow: hidden;
        }
        .error .clip:nth-of-type(2) .shadow
        {
            overflow: hidden;
            position: relative;
            box-shadow: inset 20px 0px 20px -15px rgba(150, 150, 150,0.8), 20px 0px 20px -15px rgba(150, 150, 150,0.8);
        }

        .error .clip:nth-of-type(3) .shadow:after, .error .clip:nth-of-type(1) .shadow:after
        {
            content: "";
            position: absolute;
            right: -8px;
            bottom: 0px;
            z-index: 9999;
            height: 100%;
            width: 10px;
            background: linear-gradient(90deg, transparent, rgba(173,173,173, 0.8), transparent);
            border-radius: 50%;
        }
        .error .clip:nth-of-type(3) .shadow:after
        {
            left: -8px;
        }
        .error .digit
        {
            position: relative;
            top: 8%;
            color: white;
            background: #cacaca;
            border-radius: 50%;
            display: inline-block;
            transform: skew(45deg);
        }
        .error .clip:nth-of-type(2) .digit
        {
            left: -10%;
        }
        .error .clip:nth-of-type(1) .digit
        {
            right: -20%;
        }.error .clip:nth-of-type(3) .digit
         {
             left: -20%;
         }
        .error h2
        {
            color: #A2A2A2;
            font-weight: bold;
            padding-bottom: 20px;
        }
        .error .msg
        {
            position: relative;
            z-index: 9999;
            display: block;
            background: #535353;
            color: #A2A2A2;
            border-radius: 50%;
            font-style: italic;
        }
        .error .triangle
        {
            position: absolute;
            z-index: 999;
            transform: rotate(45deg);
            content: "";
            width: 0;
            height: 0;
        }

        /* Error Page */
        @media(max-width: 767px)
        {
            /* Error Page */
            .error .clip .shadow
            {
                height: 100px;  /*Contrall*/
            }
            .error .clip:nth-of-type(2) .shadow
            {
                width: 80px;   /*Contrall play with javascript*/
            }
            .error .clip:nth-of-type(1) .shadow, .error .clip:nth-of-type(3) .shadow
            {
                width: 100px; /*Contrall*/
            }
            .error .digit
            {
                width: 80px;   /*Contrall*/
                height: 80px;  /*Contrall*/
                line-height: 80px; /*Contrall*/
                font-size: 52px;
            }
            .error h2   /*Contrall*/
            {
                font-size: 24px;
            }
            .error .msg /*Contrall*/
            {
                top: -110px;
                left: 15%;
                width: 40px;
                height: 40px;
                line-height: 40px;
                font-size: 18px;
            }
            .error span.triangle    /*Contrall*/
            {
                top: 70%;
                right: -3%;
                border-left: 10px solid #535353;
                border-top: 8px solid transparent;
                border-bottom: 8px solid transparent;
            }
            .error .container-error-404
            {
                height: 150px;
            }
            /* Error Page */
        }

        /*--------------------------------------------Framework --------------------------------*/

        .overlay { position: relative; z-index: 20; } /*done*/
        .ground-color { background: #f9f9f9; }  /*done*/  /*done*/
        .item-bg-color { background: #EAEAEA } /*done*/

        /* Padding Section*/
        .padding-top { padding-top: 10px; } /*done*/
        .padding-bottom { padding-bottom: 10px; }   /*done*/
        .padding-vertical { padding-top: 10px; padding-bottom: 10px; }
        .padding-horizontal { padding-left: 10px; padding-right: 10px; }
        .padding-all { padding: 10px; }   /*done*/

        .no-padding-left { padding-left: 0px; }    /*done*/
        .no-padding-right { padding-right: 0px; }   /*done*/
        .no-vertical-padding { padding-top: 0px; padding-bottom: 0px; }
        .no-horizontal-padding { padding-left: 0px; padding-right: 0px; }
        .no-padding { padding: 0px; }   /*done*/
        /* Padding Section*/

        /* Margin section */
        .margin-top { margin-top: 10px; }   /*done*/
        .margin-bottom { margin-bottom: 10px; } /*done*/
        .margin-right { margin-right: 10px; } /*done*/
        .margin-left { margin-left: 10px; } /*done*/
        .margin-horizontal { margin-left: 10px; margin-right: 10px; } /*done*/
        .margin-vertical { margin-top: 10px; margin-bottom: 10px; } /*done*/
        .margin-all { margin: 10px; }   /*done*/
        .no-margin { margin: 0px; }   /*done*/

        .no-vertical-margin { margin-top: 0px; margin-bottom: 0px; }
        .no-horizontal-margin { margin-left: 0px; margin-right: 0px; }

        .inside-col-shrink { margin: 0px 20px; }    /*done - For the inside sections that has also Title section*/
        /* Margin section */

        hr
        { margin: 0px; padding: 0px; border-top: 1px dashed #999; }
        /*--------------------------------------------FrameWork------------------------*/
    </style>
    <!-- Bootstrap -->
    <link href="{{ config('app.url') }}css/bootstrap.min.css" rel="stylesheet">
    <!--drop down-->
    <link rel="stylesheet" href="{{ config('app.url') }}css/dropdown.css">
    <!-- carousel -->
    <link type="text/css" rel="stylesheet" href="{{ config('app.url') }}carousel/carousel.css">
    <!--style editor-->
    <link href="{{ config('app.url') }}css/reset.css" rel="stylesheet" type="text/css">
    <link href="{{ config('app.url') }}css/style.css" rel="stylesheet" type="text/css">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ config('app.url') }}owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ config('app.url') }}owlcarousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ config('app.url') }}owlcarousel/css/owl.animate.css">
    <!--ui editor-->
    <link href="{{ config('app.url') }}js/ui/jquery-ui.css" rel="stylesheet">
    <!--ui editor-->
</head>
<body>
<!-- Error Page -->
<div class="error">
    <div class="container-floud">
        <div class="col-xs-12 ground-color text-center">
            <div class="container-error-404">
                <div class="clip"><div class="shadow"><span class="digit thirdDigit"></span></div></div>
                <div class="clip"><div class="shadow"><span class="digit secondDigit"></span></div></div>
                <div class="clip"><div class="shadow"><span class="digit firstDigit"></span></div></div>
                <div class="msg">ÜZGÜNÜM!<span class="triangle"></span></div>
            </div>
            <h2 class="h1">Sayfa silinmiş<br>ya da<br> hiç var olmamış olabilir</h2>
            <a href="{{ route('anasayfa') }}" class="btn btn-default">Anasayfa</a>
        </div>
    </div>
</div>
<!-- Error Page -->
</body>
<script src="{{ config('app.url') }}js/jquery-1.11.3.min.js"></script>
<script src="{{ config('app.url') }}js/bootstrap.min.js"></script>
<script>
    function randomNum()
    {
        "use strict";
        return Math.floor(Math.random() * 9)+1;
    }
    var loop1,loop2,loop3,time=30, i=0, number, selector3 = document.querySelector('.thirdDigit'), selector2 = document.querySelector('.secondDigit'),
        selector1 = document.querySelector('.firstDigit');
    loop3 = setInterval(function()
    {
        "use strict";
        if(i > 40)
        {
            clearInterval(loop3);
            selector3.textContent = 4;
        }else
        {
            selector3.textContent = randomNum();
            i++;
        }
    }, time);
    loop2 = setInterval(function()
    {
        "use strict";
        if(i > 80)
        {
            clearInterval(loop2);
            selector2.textContent = 0;
        }else
        {
            selector2.textContent = randomNum();
            i++;
        }
    }, time);
    loop1 = setInterval(function()
    {
        "use strict";
        if(i > 100)
        {
            clearInterval(loop1);
            selector1.textContent = 4;
        }else
        {
            selector1.textContent = randomNum();
            i++;
        }
    }, time);
</script>
</html>