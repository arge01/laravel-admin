@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading-ext">Sayfalar/ Görünüm Ayarları</h4>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                        <tr>
                            <th style="width: 5%;"></th>
                            <th>#</th>
                            <th>Adı</th>
                            <th>Linki</th>
                            <th>Ek/ Tarihi</th>
                            <th class="filter-false remove sorter-false uk-text-center">Görünürlük</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Adı</th>
                            <th>Linki</th>
                            <th>Ek/ Tarihi</th>
                            <th class="uk-text-center">Görünürlük</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($data as $i => $dd)
                            <tr id="tr-{{ $dd->id }}">
                                <td></td>
                                <td>{{ $i++ }}</td>
                                <td>{{ $dd->name }}</td>
                                <td>{{ $dd->slug }}</td>
                                <td>{{ date('m-d-Y', strtotime($dd->olusturma_tarihi)) }}</td>
                                <td class="uk-text-center">
                                    <div class="uk-width-medium-1-1">
                                        <input value="{{ $dd->id }}" data-id="{{ $dd->id }}" type="checkbox" data-switchery data-switchery-color="#7cb342" {{ $dd->visible == 1 ? 'checked' : '' }} class="switch" />
                                    </div>
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
        <button title="Güncelle" type="submit" class="md-fab md-fab-primary" id="page_settings_submit">
            <i class="material-icons">&#xE161;</i>
        </button>
    </div>
@endsection
@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
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

        function funcCheck(checkBox){
            if (checkBox.checked == true){
                return 1;
            } else {
                return 0;
            }
        }

        var data = {data: []};

        $('.switch').on('change',function () {
            data.data.push({
                'id':    $(this).val(),
                'check': funcCheck(this)
            });
            console.log(data);
        });

        $('#page_settings_submit').on('click', function () {
            $.ajax({
                type: 'POST',
                url: '{{ route('yonetim.gorunum.sayfalar') }}',
                data: data,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    swal({
                        type: 'info',
                        title: 'Başarılı...',
                        text: 'Değişiklikler kaydedildi!',
                        confirmButtonText: 'Tamam'
                    });
                },
                error: function (data) {
                    console.log(data);
                    swal({
                        type: 'error',
                        title: 'Hata...',
                        text: 'Değişiklikler kaydedilemedi!',
                        confirmButtonText: 'Tamam'
                    });
                }
            })
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
@endsection