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
                            <th>Ek/ Tarihi</th>
                            <th class="filter-false remove sorter-false uk-text-center">İşlemler</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Kategori Adı</th>
                            <th>Alt Kategorileri</th>
                            <th>Ek/ Tarihi</th>
                            <th class="uk-text-center">İşlemler</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($kategoriler as $i => $kategori)
                            <tr name="tr-{{ $kategori->id }}" id="tr-{{ $kategori->id }}">
                                <td><img src="{{ config('app.url').'images/'.'thump-'.$kategori->img }}" alt="{{ $kategori->img }}"></td>
                                <td>{{ $i }}</td>
                                <td>{{ $kategori->name }}</td>
                                <td><a target="{{ count($kategori->alt_kategorileri) > 0 ? '_blank' : '' }}" href="{{ count($kategori->alt_kategorileri) > 0 ? route('yonetim.kategori.listele', 'id='.$kategori->id) : '#' }}">{{ count($kategori->alt_kategorileri) }}' adet</a> alt kategori</td>
                                <td>{{ date('m-d-Y', strtotime($kategori->olusturma_tarihi)) }}</td>
                                <td class="uk-text-center">
                                    <a class="edit" data-id="{{ $kategori->id }}" href="#new_issue" data-uk-modal="{ center:true }"><i class="md-icon material-icons">&#xE254;</i></a>
                                    <a class="deleted" data-id="{{ $kategori->id }}" href="javascript:deleted({{ $kategori->id }})"><i class="md-icon material-icons">clear</i></a>
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
        $('.edit').on('click', function () {
            edit($(this).attr("data-id"));
        });
        function edit(ID) {
            $.get('{{ config('app.url') }}yonetim/kategori/duzenle/'+ID, function(data){
                $('.uk-modal-dialog').html("").html(data);
            });
        }
        function deleted(ID) {
            swal({
                title: 'Bu kategoriyi',
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
                url: '{{ route('yonetim.kategori.sil') }}',
                data: {
                    ID: ID
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    swal({
                        type: 'info',
                        title: 'Başarılı...',
                        text: 'Kategori Başarıyla Silindi!',
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
                        text: 'Kategori Silinirken Hata Oluştu!',
                        confirmButtonText: 'Tamam'
                    });
                }

            });
        }
    </script>
@endsection