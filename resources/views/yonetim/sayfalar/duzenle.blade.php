@extends('yonetim.master.master')

@section('content')

    <form action="{{ route('yonetim.sayfa.duzenle', $gelen->id) }}" method="post">

        {{ csrf_field() }}

        <div id="page_content_inner">

            <div class="md-card">

                <div class="md-card-content">

                    <div class="uk-grid" data-uk-grid-margin>

                        <div class="uk-width-medium-1-1">

                            <h4 class="heading-ext">Sayfa Düzenle</h4>

                            <div class="uk-form-row">

                                <div class="parsley-row">

                                    <select name="belong" id="val_select" required data-md-selectize>

                                        <option selected value="{{ $gelen->sayfa->id }}">{{ $gelen->sayfa->name }}</option>

                                        @foreach($sayfalar as $sayfa)

                                            @if($sayfa->icerigi == NULL)

                                                <option value="{{ $sayfa->id }}">{{ $sayfa->name }}</option>

                                            @endif

                                            @foreach($sayfa->tablari as $alt_sayfa)

                                                @if($alt_sayfa->icerigi == NULL)

                                                    <option value="{{ $alt_sayfa->id }}">{{ $sayfa->name.' / '.$alt_sayfa->name }}</option>

                                                @endif

                                            @endforeach

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div class="uk-form-row">

                                <label>Sayfa Başlığı</label>

                                <input type="text" class="md-input" name="name" value="{{ $gelen->name }}"/>

                            </div>

                            <div class="uk-form-row">

                                <label>Açıklama</label>

                                <textarea name="label" class="md-input" cols="10" rows="8" data-parsley-trigger="keyup"

                                            data-parsley-minlength="20" data-parsley-maxlength="800"

                                            data-parsley-validation-threshold="10">{!! $gelen->label !!}</textarea>

                            </div>

                            <div class="uk-form-row">

                                <label>Sayfa İçeriği</label>

                                <textarea name="icerik" id="wysiwyg_ckeditor" class="editor_full" cols="30" rows="20">{!! $gelen->icerik !!}</textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="md-fab-wrapper">

                    <button title="Güncelle" type="submit" class="md-fab md-fab-primary" id="page_settings_submit">

                        <i class="material-icons">&#xE161;</i>

                    </button>

                </div>

            </div>

        </div>

    </form>

@endsection

@section('javascript')

    <!-- ckeditor -->

    <script src="{{ config('app.url').'admin/' }}bower_components/ckeditor/ckeditor.js"></script>

    <script src="{{ config('app.url').'admin/' }}bower_components/ckeditor/adapters/jquery.js"></script>



    <!--  wysiwyg editors functions

    <script src="{{ config('app.url').'admin/' }}assets/js/pages/forms_wysiwyg.min.js"></script>

    -->



    <script>

        CKEDITOR.replace( 'wysiwyg_ckeditor', {

            filebrowserBrowseUrl: '{{ config("app.url")."admin/ckfinder/ckfinder.html" }}',

            filebrowserImageBrowseUrl: '{{ config("app.url")."admin/"."ckfinder/ckfinder.html?type=Images" }}',

            filebrowserFlashBrowseUrl: '{{ config("app.url")."admin/"."ckfinder/ckfinder.html?type=Flash" }}',

            filebrowserUploadUrl: '{{ config("app.url")."admin/"."ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files" }}',

            filebrowserImageUploadUrl: '{{ config("app.url")."admin/"."ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files" }}',

            filebrowserFlashUploadUrl: '{{ config("app.url")."admin/"."ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files" }}'

        } );

    </script>



    <!-- extanded -->

    <script>

        function checkTrue() {

            var checkBox = document.getElementById("switch_demo_large");

            if (checkBox.checked == true){

                $('#add-link:hidden').show()

            } else {

                $('#add-link:visible').hide()

            }

        }

        $('input[name=name]').on('keyup', function () {

            if ( $(this).val() != null ) {

                $('#add-link').html("").html('<a href="#">' + '{{ route("anasayfa").'/' }}' + ToSeoUrl($(this).val()) + '</a>');

            } else {

                $('#add-link').html("").html('Sayfa adı girilmemiş');

            }

        });

        $('#on-switch').on('click', function () {

            checkTrue();

        });

    </script>

@endsection