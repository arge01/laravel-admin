@extends('master.master')
@section('title', config('ayarlar.baslik'). ' | İLETİŞİM')
@section('content')
    <div style="padding-top: 30px" id="content">
        <div class="container">
            <div class="col-md-12">
                <div class="cont-page-item" style="text-align: center">

                        <div class="title" style="text-align:center; color: white">

                            {!! "İletişim" !!}

                        </div>

                        <h5 class="alt-title">-</h5>

                    </div>
                <div class="content pad-top-0 mar-bot-0">
                    <div class="title">
                        <span class="col-md-6 col-md-offset-3" style="font-size: 12pt; display: block">
                            İstek, öneri ve şikayetlerinizi bildiriniz.
                            <div class="line"></div>
                        </span>
                    </div>
                    <div class="page-content">
                        <div class="item-wrapper-content">
                            <div class="tabs">
                                <div id="iletisim-bilgilerimiz">
                                    <form id="contact" action="{{route('mail.gonder')}}" method="POST">
                                    <div id="bizimle-iletisime-gecin" class="col-md-6 col-md-offset-3">
                                        <div class="cont">
                                            <div class="forms-in">
                                                <div class="input-s">
                                                    <i class="fa fa-coffee" aria-hidden="true"></i>
                                                    <select required style="border: none" class="input-text" name="subject" id="subject">
                                                        <option value="">Lütfen seçiminizi yapınız</option>
                                                        <option value="İstek">İstek</option>
                                                        <option value="Öneri">Öneri</option>
                                                        <option value="Şikayet">Şikayet</option>
                                                    </select>
                                                </div>
                                                <div class="input-s"><input required name="name" class="input-text" type="text" placeholder="Adınız Soyadınız:"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                                                <div class="input-s"><input required name="email" class="input-text" type="text" placeholder="E Mail Adresiniz:"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                                
                                                <input required name="franchise" type="hidden" value="0"/>
                                                <div class="input-txt"><textarea required name="message" class="input-textarea" placeholder="Mesajınız"></textarea><i class="fa fa-commenting-o" aria-hidden="true"></i></div>
                                                <div class="clear"></div>
                                                <button name="form1" class="c-button" type="submit">Gönder!</button>
                                                <div id="result"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear: both"></div>
                                </form>
                                    <div class="cont">
                                        <ul class="address">
                                            <li><span>Mail: </span>{!! config('ayarlar.mail') !!}</li>
                                            <li><span>Tel: </span>{!! config('ayarlar.tel') !!}</li>
                                            <li><span>Adres: </span>{!! config('ayarlar.adres') !!}</li>
                                            {!! $lojistik !!}
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div><!-- and content -->
            </div>
        </div>
    </div><!-- and content -->
@endsection
@section('javascript')
<script type="text/javascript" src="{{ config('app.url') }}admin/swal2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="{{ config('app.url') }}admin/swal2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="{{ config('app.url') }}admin/swal2/sweetalert2.min.css"></script>
    
    <style>
    .swal2-container {z-index: 1000000000000000;}
    </style>

    <script type="text/javascript">
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('#contact').on('submit', function(){
                $('.c-button').hide();
                $('#result').html("Lütfen bekleyiniz...");
                $.ajax({
                  type: "POST",
                  url: "{{route('mail.gonder')}}",
                  data: $(this).serialize(),
                  success: function(response) {
                    
                    swal({
                        type: 'success',
                        title: 'Başarılı...',
                        text: response.success,
                        confirmButtonText: 'Tamam'
                    });
                    $('#result').remove();
                    return false;
                  },
                  error: function(response) {
                      swal({
                        type: 'error',
                        title: 'Hata!',
                        text: 'Mail gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
                        confirmButtonText: 'Tamam'
                    });
                    $('#result').remove();
                    return false;
                  }
                });
                return false;
            })
    </script>
@endsection