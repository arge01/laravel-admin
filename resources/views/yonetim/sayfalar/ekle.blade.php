@extends('yonetim.master.master')

@section('content')

    <form action="{{ route('yonetim.sayfa.ekle') }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div id="page_content_inner" style="padding-bottom: 0">

            <div class="md-card">

                <div class="md-card-content">

                    <div class="uk-grid" data-uk-grid-margin>

                        <div class="uk-width-medium-1-1">

                            <h4 class="heading-ext">Sayfa Ekle</h4>

                            <div class="uk-form-row">

                                <div class="parsley-row">

                                    <select name="belong" id="val_select" required data-md-selectize>

                                        <option value="0">-- BAĞIMSIZ SAYFA --</option>

                                        <option value="menu">-- MENÜYE --</option>

                                        @foreach($sayfalar as $sayfa)

                                            <option {{ $sayfa->id == $input ? 'selected' : '' }} value="{{ $sayfa->id }}">{{ $sayfa->name }}</option>

                                            @foreach($sayfa->tablari as $alt_sayfa)

                                                @if($alt_sayfa->icerigi == NULL)

                                                <option {{ $alt_sayfa->id == $input ? 'selected' : '' }} value="{{ $alt_sayfa->id }}">{{ $sayfa->name.' / '.$alt_sayfa->name }}</option>

                                                @endif

                                            @endforeach

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div style="display: none" id="alt_menu_olusturarak" class="md-card-content">

                                <h3 class="heading_a">Alt menü oluştur</h3>

                                <div class="uk-grid" data-uk-grid-margin>

                                    <div id="on-switch" class="uk-width-medium-1-3">

                                        <input name="alt_menu" type="checkbox" data-switchery data-switchery-size="large"

                                               id="switch_demo_large" value="evet" />

                                        <label id="alt_link_adi" for="switch_demo_large" class="inline-label"></label>

                                    </div>

                                </div>

                                <div id="alt_link" style="margin-top: 30px" class="uk-form-row">

                                    <label>Sayfa Linki</label>

                                    <input onClick="this.setSelectionRange(0, this.value.length)" type="text" class="md-input" name="url" value="{{ config('app.url') }}" required/>

                                </div>

                            </div>

                            <div class="uk-form-row">

                                <label>Sayfa Başlığı</label>

                                <input required type="text" class="md-input" name="name"/>

                            </div>

                            <div class="uk-form-row">

                                <label>Açıklama</label>

                                <textarea name="label" class="md-input" cols="10" rows="8" data-parsley-trigger="keyup"

                                            data-parsley-minlength="20" data-parsley-maxlength="800"

                                            data-parsley-validation-threshold="10"></textarea>

                            </div>

                            <div class="uk-form-row">

                                <label>Sayfa İçeriği</label>

                                <textarea name="icerik" id="wysiwyg_ckeditor" class="editor_full" cols="30" rows="20"></textarea>

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

                max_file_size : '10000mb',



                // User can upload no more then 20 files in one go (sets multiple_queues to false)

                max_file_count: 20,



                chunk_size: '100mb',



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

    <!-- extanded -->

    <script>



        $('#val_select').on('change', function () {

            if ( $(this).find('option:selected').val() > 0 ) {



                var text = $('#val_select').find('option:selected').text();

                $('#alt_link_adi').html("");

                $('#yeni_girilen').html("");

                $('input[name=url]').val("").val("{{ config('app.url') }}"+ToSeoUrl(text));

                checkTrue();

                $('#alt_menu_olusturarak:hidden').show();

                function checkTrue() {

                    var checkBox = document.getElementById("switch_demo_large");

                    if (checkBox.checked == true){

                        $('#alt_link_adi').html("").html(text+' / '+'<span id="yeni_girilen"></span>');

                        $('input[name=name]').val("").on('keyup', function () {

                            if ( $(this).val() != null ) {

                                $('#yeni_girilen').html("").html($(this).val());

                                $('input[name=url]').val("").val('{{ config("app.url") }}'+ToSeoUrl($('#val_select').find('option:selected').text())+'#'+ToSeoUrl($(this).val()));

                            } else {

                                $('#yeni_girilen').html("").html('Sayfa adı girilmemiş');

                            }

                        });

                    } else {

                        $('input[name=url]').val("").val("{{ config('app.url') }}"+ToSeoUrl(text));

                        $('#alt_link_adi').html("")

                    }

                }

                $('#on-switch').on('click', function () {

                    checkTrue();

                });



            } else {

                $('#alt_link_adi').html("");

                $('#yeni_girilen').html("");

                $('input[name=url]').val("").val('/');

                $('input[name=name]').val("");

                $('#alt_menu_olusturarak:visible').hide();

            }

        });



    </script>

@endsection