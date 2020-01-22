@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.altslider.ekle') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <h4 class="heading-ext">Alt Slider Ekle <span style="font-size: 7pt">Boyutları: 800 X 600</span></h4>
                            <div class="uk-form-row">
                                <label>Slider Adı</label>
                                <input type="text" class="md-input" name="name"/>
                            </div>
                            <div class="uk-form-row">
                                <label>Açıklama</label>
                                <textarea name="label" class="md-input" cols="10" rows="8" data-parsley-trigger="keyup"
                                          data-parsley-minlength="20" data-parsley-maxlength="800"
                                          data-parsley-validation-threshold="10"></textarea>
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
                            <div class="md-card-content">
                                <h3 class="heading_a">Link ata</h3>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div id="on-switch" class="uk-width-medium-1-3">
                                        <input name="link_ata" checked type="checkbox" data-switchery data-switchery-size="large"
                                               id="switch_demo_large" value="evet" />
                                        <label for="switch_demo_large" class="inline-label">Link atansın mı?</label>
                                    </div>
                                </div>
                                <div id="slider-link" style="margin-top: 30px" class="uk-form-row">
                                    <label>Slider Linki</label>
                                    <input onClick="this.setSelectionRange(0, this.value.length)" type="text"
                                           class="md-input" name="linki" value='https://www.site-adi.com/sayfa-adi'/>
                                </div>
                            </div>
                            <div style="display: none" id="slider-content" class="uk-form-row">
                                <label>Slider İçeriği</label>
                                <textarea id="wysiwyg_ckeditor" name="icerik" cols="30" rows="20"></textarea>
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
            filebrowserBrowseUrl: '{{ config('app.url').'admin/ckfinder/ckfinder.html' }}',
            filebrowserImageBrowseUrl: '{{ config('app.url').'admin/'.'ckfinder/ckfinder.html?type=Images' }}',
            filebrowserFlashBrowseUrl: '{{ config('app.url').'admin/'.'ckfinder/ckfinder.html?type=Flash' }}',
            filebrowserUploadUrl: '{{ config('app.url').'admin/'.'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files' }}',
            filebrowserImageUploadUrl: '{{ config('app.url').'admin/'.'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files' }}',
            filebrowserFlashUploadUrl: '{{ config('app.url').'admin/'.'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files' }}'
        } );
    </script>

    <!-- ionrangeslider -->
    <script src="{{ config('app.url').'admin/' }}bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="{{ config('app.url').'admin/' }}assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="{{ config('app.url').'admin/' }}bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>

    <!--  forms advanced functions -->
    <script src="{{ config('app.url').'admin/' }}assets/js/pages/forms_advanced.min.js"></script>

    <script>
        $(function() {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if(Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>

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

    <!-- extanded -->
    <script>
        function checkTrue() {
            var checkBox = document.getElementById("switch_demo_large");
            if (checkBox.checked == true){
                $('#slider-link:hidden').show();
                $('#slider-content:visible').hide()
            } else {
                $('#slider-content:hidden').show();
                $('#slider-link:visible').hide()
            }
        }
        $('#on-switch').on('click', function () {
            checkTrue();
        });
    </script>
@endsection