@extends('yonetim.master.master')

@section('content')

    <div id="page_content_inner">

        <div class="md-card">

            <div class="md-card-content">

                <h4 class="heading-ext">Ürünler</h4>

                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">

                        <thead>

                        <tr>

                            <th style="width: 15%">Resmi</th>

                            <th>#</th>

                            <th>Proje Adı</th>

                            <th>Kategorisi</th>

                            <th>Modelleri</th>

                            <th>Galerisi</th>

                            <th>Ek/ Tarihi</th>

                            <th class="filter-false remove sorter-false uk-text-center">İşlemler</th>

                        </tr>

                        </thead>

                        <tfoot>

                        <tr>

                            <th>Resmi</th>

                            <th>#</th>

                            <th>Proje Adı</th>

                            <th>Kategorisi</th>

                            <th>Modelleri</th>

                            <th>Galerisi</th>

                            <th>Ek/ Tarihi</th>

                            <th class="uk-text-center">İşlemler</th>

                        </tr>

                        </tfoot>

                        <tbody>

                        @foreach($urunler as $i => $urun)

                            <tr id="tr-{{ $urun->id }}">

                                <td><img src="{{ config('app.url').'images/thump/thump-'.$urun->img }}" alt=""></td>

                                <td>{{ $i }}</td>

                                <td>{{ $urun->name }}</td>

                                <td>

                                    @if($urun->kategorisi == NULL)

                                        <span class="ext">EKLENMEMİŞ</span>

                                    @else

                                        @php

                                            $ismi = \App\Models\Kategoriler::where('id', $urun->kategorisi->belong)->first();

                                            echo $ismi["name"].' / '.$urun->kategorisi->name

                                        @endphp

                                    @endif

                                </td>

                                <td>
                                    <a target="_blank" href="{{ route('yonetim.model.listele', $urun->id) }}">
                                        {!! $urun->methodlari == NULL ? '0 adet' : count($urun->methodlari).' adet' !!}</a> Model  
                                    <a target="_blank" href="{{ route('yonetim.model.ekle', $urun->id) }}">Yeni Model Ekle</a>
                                </td>

                                <td>

                                    @if( count($urun->galerisi) > 0 )

                                        <a target="_blank" href="{{ route('yonetim.galeri.listele', 'data=proje&key='.$urun->id) }}">EKLENMİŞ / DÜZENLE</a>

                                    @else

                                        <a target="_blank" href="{{ route('yonetim.galeri.ekle', 'data=proje&key='.$urun->id) }}">EKLENMEMİŞ / EKLE</a>

                                    @endif

                                </td>

                                <td>{{ date('m-d-Y', strtotime($urun->olusturma_tarihi)) }}</td>

                                <td class="uk-text-center">

                                    <a href="{{ route('yonetim.proje.duzenle', $urun->id) }}"><i class="md-icon material-icons">&#xE254;</i></a>

                                    <a class="deleted" data-id="{{ $urun->id }}" href="javascript:deleted({{ $urun->id }})"><i class="md-icon material-icons">clear</i></a>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

                <ul class="uk-pagination ts_pager">

                    <li data-uk-tooltip title="Sayfa Seç">

                        <select class="ts_gotoPage ts_selectize"></select>

                    </li>

                    <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>

                    <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>

                    <li><span class="pagedisplay"></span></li>

                    <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>

                    <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>

                    <li data-uk-tooltip title="Sayfa Sayısı">

                        <select class="pagesize ts_selectize">

                            <option value="5">5</option>

                            <option value="10">10</option>

                            <option value="25">25</option>

                            <option value="50">50</option>

                        </select>

                    </li>

                </ul>

            </div>

        </div>

    </div>

    <div class="md-fab-wrapper">

        <a title="Yeni Ekle" class="md-fab md-fab-accent" href="{{ route('yonetim.proje.ekle') }}">

            <i class="material-icons">&#xE145;</i>

        </a>

    </div>

@endsection

@section('javascript')

    <!-- tablesorter -->

    <script src="{{ config('app.url').'admin/' }}bower_components/tablesorter/dist/js/jquery.tablesorter.min.js"></script>

    <script src="{{ config('app.url').'admin/' }}bower_components/tablesorter/dist/js/jquery.tablesorter.widgets.min.js"></script>

    <script src="{{ config('app.url').'admin/' }}bower_components/tablesorter/dist/js/widgets/widget-alignChar.min.js"></script>

    <script src="{{ config('app.url').'admin/' }}bower_components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js"></script>



    <!--  tablesorter functions -->

    <script src="{{ config('app.url').'admin/' }}assets/js/pages/plugins_tablesorter.min.js"></script>



    <script>

        $('html').on('click', function () {

            $('.select-label').css({'top': '25px', 'font-size': '14px'});

        });

        $('.md-select').on('click', function (event) {

            event.stopPropagation();

            $('.select-label').css({'top': '0', 'font-size': '12px'});

        });

    </script>



    <script>

        $(function() {

            var $switcher = $('#style_switcher'),

                $switcher_toggle = $('#style_switcher_toggle'),

                $theme_switcher = $('#theme_switcher'),

                $mini_sidebar_toggle = $('#style_sidebar_mini'),

                $boxed_layout_toggle = $('#style_layout_boxed'),

                $body = $('body');





            $switcher_toggle.click(function(e) {

                e.preventDefault();

                $switcher.toggleClass('switcher_active');

            });



            $theme_switcher.children('li').click(function(e) {

                e.preventDefault();

                var $this = $(this),

                    this_theme = $this.attr('data-app-theme');



                $theme_switcher.children('li').removeClass('active_theme');

                $(this).addClass('active_theme');

                $body

                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')

                    .addClass(this_theme);



                if(this_theme == '') {

                    localStorage.removeItem('altair_theme');

                } else {

                    localStorage.setItem("altair_theme", this_theme);

                }



            });



            // hide style switcher

            $document.on('click keyup', function(e) {

                if( $switcher.hasClass('switcher_active') ) {

                    if (

                        ( !$(e.target).closest($switcher).length )

                        || ( e.keyCode == 27 )

                    ) {

                        $switcher.removeClass('switcher_active');

                    }

                }

            });



            // get theme from local storage

            if(localStorage.getItem("altair_theme") !== null) {

                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();

            }





            // toggle mini sidebar



            // change input's state to checked if mini sidebar is active

            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {

                $mini_sidebar_toggle.iCheck('check');

            }



            $mini_sidebar_toggle

                .on('ifChecked', function(event){

                    $switcher.removeClass('switcher_active');

                    localStorage.setItem("altair_sidebar_mini", '1');

                    location.reload(true);

                })

                .on('ifUnchecked', function(event){

                    $switcher.removeClass('switcher_active');

                    localStorage.removeItem('altair_sidebar_mini');

                    location.reload(true);

                });





            // toggle boxed layout



            // change input's state to checked if mini sidebar is active

            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {

                $boxed_layout_toggle.iCheck('check');

                $body.addClass('boxed_layout');

                $(window).resize();

            }



            // toggle mini sidebar

            $boxed_layout_toggle

                .on('ifChecked', function(event){

                    $switcher.removeClass('switcher_active');

                    localStorage.setItem("altair_layout", 'boxed');

                    location.reload(true);

                })

                .on('ifUnchecked', function(event){

                    $switcher.removeClass('switcher_active');

                    localStorage.removeItem('altair_layout');

                    location.reload(true);

                });





        });

    </script>



    <!-- ajax -->

    <script>

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        function deleted(ID) {

            swal({

                title: 'Bu projeyi',

                text: "Silmek istediğinizden eminmisiniz?",

                type: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#3085d6',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Evet, sil!',

                cancelButtonText: 'Hayır'

            }).then((result) => {

                if (result.value) {

                    del(ID);

                }

            });

        }

        function del(ID) {

            $.ajax({

                type: 'POST',

                url: '{{ route('yonetim.proje.sil') }}',

                data: {

                    ID: ID

                },

                dataType: 'json',

                success: function (data) {

                    console.log(data);

                    swal({

                        type: 'info',

                        title: 'Başarılı...',

                        text: 'Proje Başarıyla Silindi!',

                        confirmButtonText: 'Tamam'

                    });

                    $('tr[name=tr-'+ID+']').remove();

                    $('#tr-'+ID).remove();

                },

                error: function (data) {

                    console.log(data);

                    swal({

                        type: 'error',

                        title: 'Hata...',

                        text: 'Ürün Silinirken Hata Oluştu!',

                        confirmButtonText: 'Tamam'

                    });

                }



            });

        }

    </script>

@endsection