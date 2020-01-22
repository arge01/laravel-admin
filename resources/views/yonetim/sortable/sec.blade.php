@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading-ext">{{ $name }}</h4>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair"
                           id="ts_pager_filter">
                        <thead>
                        <tr>
                            <th style="width: 5%;"></th>
                            <th>#</th>
                            <th>Kategori Adı</th>
                            <th>Alt Kategorileri</th>
                            <th>İçerik Sayısı</th>
                            <th class="filter-false remove sorter-false uk-text-center">Liste(sortable) Ayarları</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Kategori Adı</th>
                            <th>Alt Kategorileri</th>
                            <th>İçerik Sayısı</th>
                            <th class="uk-text-center">Liste(sortable) Ayarları</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($kategoriler as $i => $kategori)
                            <tr name="tr-{{ $kategori->id }}" id="tr-{{ $kategori->id }}">
                                <td></td>
                                <td>{{ $i }}</td>
                                <td>{{ $kategori->name }}</td>
                                <td><a target="{{ count($kategori->alt_kategorileri) > 0 ? '_blank' : '' }}" href="{{ count($kategori->alt_kategorileri) > 0 ? route('yonetim.kategori.listele', 'id='.$kategori->id) : '#' }}">{{ count($kategori->alt_kategorileri) }}' adet</a> alt kategori</td>
                                <td>{{ count($kategori->projeler).' ADET' }}</td>
                                <td class="uk-text-center">
                                    <a target="_blank" href="{{ route('yonetim.sortable.getir', $kategori->id) }}">Seç</a>
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
        <a title="Yeni Ekle" class="md-fab md-fab-accent" href="{{ route('yonetim.kategori.ekle') }}">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div class="uk-modal" id="new_issue">
        <div class="uk-modal-dialog">
            <div class="loader">Yükleniyor...</div>
        </div>
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

    <!-- ajax -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection