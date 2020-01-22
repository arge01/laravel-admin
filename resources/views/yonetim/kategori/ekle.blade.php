@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.kategori.ekle') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <h4 class="heading-ext">Kategori Ekle</h4>
                        <div class="uk-form-row">
                            <div class="parsley-row">
                                <select name="belong" id="val_select" required data-md-selectize>
                                    <option value="0">Üst Kategori Yok</option>
                                    @foreach($kategoriler as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                        <optgroup label="{{ $kategori->name }}">
                                        @foreach($kategori->alt_kategorileri as $alt_kategori)
                                                <option value="{{ $alt_kategori->id }}">{{ $alt_kategori->name }}</option>
                                        @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label>Kategori Adı</label>
                            <input name="name" type="text" class="md-input"  />
                        </div>
                        <div class="uk-form-row">
                            <div class="md-card">
                                <div class="md-card-content">
                                    <h3 class="heading_a uk-margin-bottom">Resim Ekle</h3>
                                    <div class="uk-form-file md-btn md-btn-primary">
                                        Seç
                                        <input id="form-file" type="file" name="img" accept="image/*">
                                    </div>
                                    <div style="display: none; max-height: 200px" id="result-file"
                                         class="md-card-content"><img style="max-height: 200px" id="result"/></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md-fab-wrapper">
            <button title="Ekle" type="submit" class="md-fab md-fab-primary" id="page_settings_submit">
                <i class="material-icons">&#xE161;</i>
            </button>
        </div>
    </div>
    </form>
@endsection
@section('javascript')
    <!-- d3 -->
    <script src="{{ config('app.url').'admin/' }}bower_components/d3/d3.min.js"></script>
    <script src="{{ config('app.url').'admin/' }}bower_components/peity/jquery.peity.min.js"></script>
    <!-- countUp -->
    <script src="{{ config('app.url').'admin/' }}bower_components/countUp.js/countUp.min.js"></script>
    <!-- handlebars.js -->
    <script src="{{ config('app.url').'admin/' }}bower_components/handlebars/handlebars.min.js"></script>
    <script src="{{ config('app.url').'admin/' }}assets/js/custom/handlebars_helpers.min.js"></script>
    <!-- CLNDR -->
    <script src="{{ config('app.url').'admin/' }}bower_components/clndr/src/clndr.js"></script>
    <!-- fitvids -->
    <script src="{{ config('app.url').'admin/' }}bower_components/fitvids/jquery.fitvids.js"></script>
    <!-- extanded -->
    <script type="text/javascript">
        $('input[name=img]').change(function(e){
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                var fotograf = e.target.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(fotograf);
                reader.onload = function(evt){
                    $('#result').attr('src', evt.target.result);
                    $('#result-file:hidden').show('slow');
                }
            } else {
                alert('Tarayıcınızın önizleme desteği bulunmuyor.');
            }
        });
    </script>
@endsection