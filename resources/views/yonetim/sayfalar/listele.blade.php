@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading-ext">Sayfalar</h4>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Sayfa Adı</th>
                            <th>Linki</th>
                            <th>Galerisi</th>
                            <th>Ek/ Tarihi</th>
                            <th class="filter-false remove sorter-false uk-text-center">İşlemler</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Sayfa Adı</th>
                            <th>Linki</th>
                            <th>Galerisi</th>
                            <th>Ek/ Tarihi</th>
                            <th class="uk-text-center">İşlemler</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            @foreach($icerikler as $i => $sayfa)
                                <tr name="tr-{{ $sayfa->id }}" id="tr-{{ $sayfa->id }}">
                                    <td></td>
                                    <td>{{ $i }}</td>
                                    <td>{{ $sayfa->name }}</td>
                                    <td>
                                        @php
                                        $ana_sayfa = \App\Models\Sayfalar::where('id', $sayfa->sayfa->belong)->first();
                                        @endphp
                                        <a target="_blank" href="{{ route('sayfa', $sayfa->sayfa->slug) }}">{{ $ana_sayfa == NULL ? $sayfa->sayfa->name : $ana_sayfa->name.' / '.$sayfa->sayfa->name }}</a>
                                    </td>
                                    <td>
                                        @php
                                        $kategori = \App\Models\Sayfalar::where('id', $sayfa->sayfasi)->first();
                                        @endphp
                                        @if( count($kategori->galerisi) > 0 )
                                            <a target="_blank" href="{{ route('yonetim.galeri.listele', 'data=sayfa&key='.$kategori->id) }}">EKLENMİŞ / DÜZENLE</a>
                                        @else
                                            <a target="_blank" href="{{ route('yonetim.galeri.ekle', 'data=sayfa&key='.$kategori->id) }}">EKLENMEMİŞ / EKLE</a>
                                        @endif
                                    </td>
                                    <td>{{ date('m-d-Y', strtotime($sayfa->olusturma_tarihi)) }}</td>
                                    <td class="uk-text-center">
                                        <a href="{{ route('yonetim.sayfa.duzenle', $sayfa->id) }}"><i class="md-icon material-icons">&#xE254;</i></a>
                                        <a class="deleted" data-id="{{ $sayfa->id }}" href="javascript:deleted({{ $sayfa->id }})"><i class="md-icon material-icons">clear</i></a>
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
        <a title="Yeni Ekle" class="md-fab md-fab-accent" href="{{ route('yonetim.sayfa.ekle') }}">
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
                title: 'Bu sayfayı',
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
                url: '{{ route('yonetim.sayfa.sil') }}',
                data: {
                    ID: ID
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if ( data.success ) {
                        swal({
                            type: 'success',
                            title: 'Başarılı...',
                            text: 'Sayfa Başarıyla Silindi!',
                            confirmButtonText: 'Tamam'
                        });
                        $('tr[name=tr-'+ID+']').remove();
                        $('#tr-'+ID).remove();
                    } else if ( data.info ) {
                        swal({
                            type: 'info',
                            title: 'Silinemez...',
                            text: 'Bu sayfanın içerik ilişkisi bulunmamakta!',
                            confirmButtonText: 'Tamam'
                        });
                    }
                },
                error: function (data) {
                    console.log(data);
                    swal({
                        type: 'error',
                        title: 'Hata...',
                        text: 'Sayfa Silinirken Hata Oluştu!',
                        confirmButtonText: 'Tamam'
                    });
                }

            });
        }
    </script>
@endsection