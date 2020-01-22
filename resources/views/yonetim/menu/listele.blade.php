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
                            <th></th>
                            <th>#</th>
                            <th>Menü Adı</th>
                            <th>Alt Menüleri</th>
                            <th>İçeriği</th>
                            <th>Galerisi</th>
                            <th>Ek/ Tarihi</th>
                            <th class="filter-false remove sorter-false uk-text-center">İşlemler</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Menü Adı</th>
                            <th>Alt Menüleri</th>
                            <th>İçeriği</th>
                            <th>Galerisi</th>
                            <th>Ek/ Tarihi</th>
                            <th class="uk-text-center">İşlemler</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($kategoriler as $i => $kategori)
                            <tr name="tr-{{ $kategori->id }}" id="tr-{{ $kategori->id }}">
                                <td></td>
                                <td>{{ $i }}</td>
                                <td>{{ $kategori->name }}</td>
                                <td><a target="{{ count($kategori->tablari) > 0 ? '_blank' : '' }}" href="{{ count($kategori->tablari) > 0 ? route('yonetim.menu.listele', 'id='.$kategori->id) : '#' }}">{{ count($kategori->tablari) }}' adet</a> alt menüleri</td>
                                <td>
                                    @if ( $kategori->content != 1 )
                                        <a target="_blank" href="{{ $kategori->icerigi != NULL ? route('yonetim.sayfa.duzenle', $kategori->icerigi->id) : route('yonetim.sayfa.ekle', 'id='.$kategori->id) }}">{{ $kategori->icerigi != NULL ? 'EKLENMİŞ / DÜZENLE' : 'EKLENMEMİŞ / EKLE' }}</a>
                                    @else
                                        İÇERİK İLİŞKİSİ YOK
                                    @endif
                                </td>
                                <td>
                                    @if( $kategori->content != 1 )
                                        @if( count($kategori->galerisi) > 0 )
                                            <a target="_blank" href="{{ route('yonetim.galeri.listele', 'data=sayfa&key='.$kategori->id) }}">EKLENMİŞ / DÜZENLE</a>
                                        @else
                                            <a target="_blank" href="{{ route('yonetim.galeri.ekle', 'data=sayfa&key='.$kategori->id) }}">EKLENMEMİŞ / EKLE</a>
                                        @endif
                                    @else
                                        GALERİ İLİŞKİSİ YOK
                                    @endif
                                </td>
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
            $.get('{{ config('app.url') }}yonetim/menu/duzenle/'+ID, function(data){
                $('.uk-modal-dialog').html("").html(data);
            });
        }
        function deleted(ID) {
            swal({
                title: 'Bu menüyü',
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
                url: '{{ route('yonetim.menu.sil') }}',
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
                            text: 'Menü Başarıyla Silindi!',
                            confirmButtonText: 'Tamam'
                        });
                        $('tr[name=tr-'+ID+']').remove();
                        $('#tr-'+ID).remove();
                    } else if ( data.info ) {
                        swal({
                            type: 'info',
                            title: 'Silinemez...',
                            text: 'Bu menünün içerik ilişkisi bulunmamakta!',
                            confirmButtonText: 'Tamam'
                        });
                    }
                },
                error: function (data) {
                    console.log(data);
                    swal({
                        type: 'error',
                        title: 'Hata...',
                        text: 'Menü Silinirken Hata Oluştu!',
                        confirmButtonText: 'Tamam'
                    });
                }

            });
        }
    </script>
@endsection