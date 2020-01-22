@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.proje.ekle') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div id="page_content_inner" style="padding-bottom: 0">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <h4 class="heading-ext">Ürün Ekle <span style="font-size: 7pt">Boyutları: 370 X 492</span></h4>
                            <div class="uk-form-row">
                                <label>Ürün Adı</label>
                                <input type="text" class="md-input" name="name"/>
                            </div>
                            <div class="uk-form-row">
                                <label>Açıklama</label>
                                <textarea name="label" class="md-input" cols="10" rows="8" data-parsley-trigger="keyup"
                                          data-parsley-minlength="20" data-parsley-maxlength="800"
                                          data-parsley-validation-threshold="10"></textarea>
                            </div>
                            <div class="uk-form-row">
                                <div class="parsley-row">
                                    <label>Kategori Seç</label>
                                    <select id="kategori" name="kategori[]" multiple>
                                    </select>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <h3 class="heading_a uk-margin-bottom">Resim Ekle</h3>
                                        <div class="uk-form-file md-btn md-btn-primary">
                                            Seç
                                            <input id="form-file" type="file" name="img" accept="image/*">
                                        </div>
                                        <div style="display: none" id="result-file" class="md-card-content"><img
                                                    id="result" style="max-height: 200px"/></div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-form-row">
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <h3 class="heading_a uk-margin-bottom">Katalog Ekle</h3>
                                        <div class="uk-form-file md-btn md-btn-primary">
                                            Seç (sadece pdf)
                                            <input type="file" name="pdf" accept="pdf/*">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-form-row">
                                <label>Ürün İçeriği</label>
                                <textarea name="icerik" id="wysiwyg_ckeditor" cols="30" rows="20"></textarea>
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
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-1">
                        <div class="uk-form-row">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-large-1-1">
                                    <div class="uk-form-row">
                                        <label>Resim / Resimler Seçin</label>
                                        <div id="uploader">
                                            <p>Tarayıcı desteği bulunmamakta.</p>
                                        </div>
                                        <input type="hidden" name="{uploaderId}_files[]" value="{id}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        $.getJSON("{{ route('yonetim.kategori.api') }}", function (data) {
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
    <script type="text/javascript" src="{{ config('app.url').'admin/plupload/' }}js/jquery-ui.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ config('app.url').'admin/plupload/' }}js/plupload.full.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ config('app.url').'admin/plupload/' }}js/jquery.ui.plupload.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="https://www.plupload.com/i18n/export/tr" charset="UTF-8"></script>
    <link type="text/css" rel="stylesheet" href="{{ config('app.url').'admin/plupload/' }}js/jquery-ui.min.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="{{ config('app.url').'admin/plupload/' }}js/jquery.ui.plupload.css" media="screen" />
    <script>
        function plupLOADget() {

            $("#uploader").plupload({
                // General settings
                runtimes : 'html5,flash,silverlight,html4',
                url : "{{ route('yonetim.resimleri.al') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                multipart_params : {
                    'sayfa': 1,
                },

                // Maximum file size
                max_file_size : '1000mb',

                // User can upload no more then 20 files in one go (sets multiple_queues to false)
                max_file_count: 20,

                chunk_size: '1mb',

                // Resize images on clientside if we can
                /*
                resize : {
                    width : 200,
                    height : 200,
                    quality : 90,
                    crop: true // crop to exact dimensions
                },
                */

                // Specify what files to browse for
                filters : [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip,avi"}
                ],

                // Rename files by clicking on their titles
                rename: true,

                // Sort files
                sortable: true,

                // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                dragdrop: true,

                // Views to activate
                views: {
                    list: true,
                    thumbs: true, // Show thumbs
                    active: 'thumbs'
                },

                // Flash settings
                flash_swf_url : '{{ config('app.url').'admin/plupload' }}js/Moxie.swf',

                // Silverlight settings
                silverlight_xap_url : '{{ config('app.url').'admin/plupload' }}js/Moxie.xap'
            });
        }
        plupLOADget();
    </script>
@endsection