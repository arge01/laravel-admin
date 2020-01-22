@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.uye.ekle') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <h4 class="heading-ext">Üye Ekle</h4>
                            <div class="uk-form-row">
                                <label>Mail</label>
                                <input type="text" class="md-input" name="mail" required/>
                            </div>
                            <div class="uk-form-row">
                                <label>Üye Adı</label>
                                <input type="text" class="md-input" name="name" required/>
                            </div>
                            <div class="uk-form-row">
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <h3 class="heading_a uk-margin-bottom">Avatar Ekle</h3>
                                        <div class="uk-form-file md-btn md-btn-primary">
                                            Seç
                                            <input id="form-file" type="file" name="img" accept="image/*">
                                        </div>
                                        <div style="display: none" id="result-file" class="md-card-content"><img
                                                    id="result" style="max-height: 200px"/></div>
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

    <!-- page specific plugins -->
    <!-- ionrangeslider -->
    <script src="{{ config('app.url').'admin/' }}bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="{{ config('app.url').'admin/' }}assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="{{ config('app.url').'admin/' }}bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>

    <!-- select -->
    <script>
        $.getJSON("{{ route('yonetim.urunler.api') }}", function (data) {
            $("#kategori").selectize({
                plugins: {
                    remove_button: {
                        label: ""
                    }
                },
                options: data,
                maxItems: null,
                valueField: "id",
                labelField: "title",
                searchField: "title",
                create: !1,
                render: {
                    option: function (t, e) {
                        return '<div class="option"><span class="title">' + e(t.title) + "</span></div>"
                    },
                    item: function (t, e) {
                        return '<div class="item"><a href="' + e(t.url) + '" target="_blank">' + e(t.title) + "</a></div>"
                    }
                },
                onDropdownOpen: function (t) {
                    t.hide().velocity("slideDown", {
                        begin: function () {
                            t.css({
                                "margin-top": "0"
                            })
                        },
                        duration: 200,
                        easing: easing_swiftOut
                    })
                },
                onDropdownClose: function (t) {
                    t.show().velocity("slideUp", {
                        complete: function () {
                            t.css({
                                "margin-top": ""
                            })
                        },
                        duration: 200,
                        easing: easing_swiftOut
                    })
                }
            });
        });
    </script>

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