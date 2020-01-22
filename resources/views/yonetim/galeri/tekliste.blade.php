@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <div id="gallery-list-{{ $key }}" class="md-card">
            <div class="md-card-content">
                <div class="delete-all">
                    <a href="javascript:deletedAll({{ $key }})">x</a>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <h4 class="heading_c uk-margin-small-bottom">Galeri</h4>
                        <div id="gallery-sayfa-{{ $key }}"
                             class="gallery-all sortable uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3"
                             data-uk-grid-margin>
                            @foreach( $galeriler as $i => $galeri )
                                <li class="gallery-li" style="position: relative" id="{{ $galeri->id }}">
                                    <div style="cursor: pointer" title="sürükle/aç" class="md-card">
                                        <div href="{{ config('app.url').'images/'.$galeri->img }}"
                                             data-uk-lightbox="{group:'gallery-0'}" class="md-card-head head_background"
                                             style="background-image: url('{{ config("app.url").'images/'.$galeri->img }}')"></div>
                                        <div class="md-card-content"><h4
                                                    style="width: 100%; overflow: hidden">{{ $galeri->name }}</h4>
                                            .
                                        </div>
                                    </div>
                                    <div style="position: absolute;right: 15px;bottom: 15px;"
                                         class="gallery_grid_image_menu"
                                         data-uk-dropdown="{pos:'top-right'}">
                                        <i class="md-icon material-icons">&#xE5D4;</i>
                                        <div class="uk-dropdown uk-dropdown-small">
                                            <ul class="uk-nav">
                                                <li>
                                                    <a href="{{ route('yonetim.galeri.duzenle', $galeri->img) }}"><i
                                                                class="material-icons uk-margin-small-right">&#xE150;</i>
                                                        Güncelle</a></li>
                                                <li><a class="deleted"
                                                       href="javascript:deleted('{{ $galeri->id }}')"><i
                                                                class="material-icons uk-margin-small-right">&#xE872;</i>
                                                        Sil</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                                <div>
                                    <a target="_blank" style="display: block" href="{{ route('yonetim.galeri.ekle', 'data='.$data.'&key='.$key) }}" class="md-card">
                                        <div class="md-card-head head_background" style="background-image: url('{{ config('app.url').'admin/' }}assets/img/gallery/plus.png')"></div>
                                        <div class="md-card-content"><h4>Yeni Ekle</h4>.</div>
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ config('app.url').'admin/' }}assets/js/ui-editors.js"></script>
    <!-- dragula.js -->
    <script src="{{ config('app.url').'admin/' }}bower_components/dragula.js/dist/dragula.min.js"></script>

    <!--  sortable functions -->
    <script src="{{ config('app.url').'admin/' }}assets/js/pages/components_sortable.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.sortable').sortable({
            stop:function () {
                $.map( $(this).find('li'),function (el) {
                    var itemID = el.id;
                    var itemINdex = $(el).index();
                    var data = {
                        'id': itemID,
                        'sortable': itemINdex
                    };
                    if ( data['id'] != "")
                    {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('yonetim.galeri.sortable') }}',
                            data: data,
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        })
                    }
                });
            }
        });
        function deleted(ID) {
            swal({
                title: 'Bu dosyayı',
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
                url: '{{ route('yonetim.galeri.sil') }}',
                data: {
                    ID: ID
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    swal({
                        type: 'info',
                        title: 'Başarılı...',
                        text: 'Dosya Başarıyla Silindi!',
                        confirmButtonText: 'Tamam'
                    });
                    ID = ID.split('.');
                    $('#'+ID[0]).remove();
                    window.location.href = "{{ route('yonetim.galeri.sil') }}";
                },
                error: function (data) {
                    console.log(data);
                    swal({
                        type: 'error',
                        title: 'Hata...',
                        text: 'Dosya Silinirken Hata Oluştu!',
                        confirmButtonText: 'Tamam'
                    });
                }
            });
        }
        function deletedAll(ID) {
            swal({
                title: 'Bu galeriyi',
                text: "Silmek istediğinizden eminmisiniz?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Hayır'
            }).then((result) => {
                if (result.value) {
                    swal({
                        title: 'Sliniyor...!',
                        html: 'Lütfen bekleyiniz <strong></strong>...',
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });
                    delAll(ID);
                }
            });
        }
        function delAll(ID) {
            jQuery.each( $('#gallery-sayfa-'+ID).find('li.gallery-li'), function( i, val ) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('yonetim.galeri.sil') }}',
                    data: {
                        ID: $(this).attr('id')
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $(this).remove();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            $('#gallery-list-'+ID).remove();
            swal.close();
        }
    </script>
@endsection