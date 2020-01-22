@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <div class="gallery_grid uk-grid-width-medium-1-4 uk-grid-width-large-1-5" data-uk-grid="{gutter: 16}">
            @foreach($datalar as $data)
                @php
                    $yeni = $data;
                    $turu = explode('.', $yeni);
                @endphp
                <div id="{{ $turu[0] }}" class="data">
                <div class="md-card md-card-hover">
                    <div class="gallery_grid_item md-card-content">
                        <a href="{{ config('app.url').'images/'.$data }}" data-uk-lightbox="{group:'gallery'}">
                            <img src="{{ config('app.url').'images/'.$data }}" alt="">
                        </a>
                        <div class="gallery_grid_image_caption">
                            <div class="gallery_grid_image_menu" data-uk-dropdown="{pos:'top-right'}">
                                <i class="md-icon material-icons">&#xE5D4;</i>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav">
                                        <li><a href="{{ route('yonetim.dosya.duzenle', $data) }}"><i class="material-icons uk-margin-small-right">&#xE150;</i>
                                                Güncelle</a></li>
                                        <li><a class="deleted" href="javascript:deleted('{{ $data }}')"><i class="material-icons uk-margin-small-right">&#xE872;</i>
                                                Sil</a></li>
                                    </ul>
                                </div>
                            </div>
                            <span class="gallery_image_title uk-text-truncate">Türü: {{ $turu[1] }}</span>
                            <span class="uk-text-muted uk-text-small"><i style="display: block; overflow: hidden; width: 100%;">{{ $turu[0] }}</i></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
@section('javascript')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            url: '{{ route('yonetim.dosya.yonetimi') }}',
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
                window.location.href = "{{ route('yonetim.dosya.yonetimi') }}";
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
</script>
@endsection