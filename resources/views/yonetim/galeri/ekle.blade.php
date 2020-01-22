@extends('yonetim.master.master')

@section('content')

    <div id="page_content_inner">

        <div class="md-card">

            <div class="md-card-content">

                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-1">

                        <h4 class="heading-ext">Galeri Oluştur veya Resim Yükle</h4>

                        <div class="uk-form-row">

                            <div style="padding: 30px; text-align: center" class="uk-width-medium-1-1 check">

                                <span class="icheck-inline">

                                    <label class="css-radio-button">Sayfa'ya Oluştur

                                        <input {{ $input == 'sayfa' ? 'checked' : '' }} id="sayfa" name="iliskilendir" type="radio">

                                        <span class="checkmark"></span>

                                    </label>

                                </span>

                                <span class="icheck-inline">

                                    <label class="css-radio-button">Ürüne'e Oluştur

                                        <input {{ $input == 'proje' ? 'checked' : '' }} name="iliskilendir" id="proje" type="radio" >

                                        <span class="checkmark"></span>

                                    </label>

                                </span>

                            </div>

                        </div>

                        @if($input != NULL)

                        <div style="margin-bottom: 30px" class="uk-form-row">

                            <div class="uk-grid" data-uk-grid-margin>

                                <div class="uk-width-large-1-1">

                                    <select name="{{ $input }}" id="getir" data-md-selectize>

                                        <option selected value="0">Nereye Oluşturulsun?</option>

                                        @foreach($data as $getir)

                                            <option {{ $key != NULL ? 'disabled' : '' }} {{ $key == $getir->id ? 'selected' : '' }} value="{{ $getir->id }}">{{ $getir->name }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                        @endif

                        <div class="uk-form-row">

                            <div class="uk-grid" data-uk-grid-margin>

                                <div class="uk-width-large-1-1">

                                    <div class="uk-form-row">

                                        <label>Resim / Resimler Seçin</label>

                                        <div id="uploader">

                                            <p>Önce seçiminizi yapınız.</p>

                                        </div>

                                        <input type="hidden" name="{uploaderId}_files[]" value="{id}" />

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

    <script type="text/javascript" src="{{ config('app.url').'admin/plupload/' }}js/jquery-ui.min.js" charset="UTF-8"></script>

    <script type="text/javascript" src="{{ config('app.url').'admin/plupload/' }}js/plupload.full.min.js" charset="UTF-8"></script>

    <script type="text/javascript" src="{{ config('app.url').'admin/plupload/' }}js/jquery.ui.plupload.min.js" charset="UTF-8"></script>

    <script type="text/javascript" src="https://www.plupload.com/i18n/export/tr" charset="UTF-8"></script>

    <link type="text/css" rel="stylesheet" href="{{ config('app.url').'admin/plupload/' }}js/jquery-ui.min.css" media="screen" />

    <link type="text/css" rel="stylesheet" href="{{ config('app.url').'admin/plupload/' }}js/jquery.ui.plupload.css" media="screen" />

    <script type="text/javascript">

        $('.check input').on('click', function(){

            id = $(this).attr('id');

            if ( id != undefined ) {

                window.location.href = "{{ route('yonetim.galeri.ekle', 'data=') }}"+$(this).attr('id');

            } else {

                window.location.href = "{{ route('yonetim.galeri.ekle') }}";

            }

        });

        @if ( $input != NULL )

            @if( $key == NULL )

            $('#getir').on('change', function () {

                var plupLOADget = function() {

                    $("#uploader").plupload({

                        // General settings

                        runtimes : 'html5,flash,silverlight,html4',

                        url : "{{ route('yonetim.galeri.ekle') }}",

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },

                        multipart_params : {

                            'sayfa': $('select[name=sayfa]').find('option:selected').val(),

                            'proje': $('select[name=proje]').find('option:selected').val(),

                            'urun': $('select[name=urun]').find('option:selected').val(),

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

                };

                plupLOADget();

            });

            @else

            function plupLOADget() {



                $("#uploader").plupload({

                    // General settings

                    runtimes: 'html5,flash,silverlight,html4',

                    url: "{{ route('yonetim.galeri.ekle') }}",

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    },

                    multipart_params: {

                        'sayfa': $('select[name=sayfa]').find('option:selected').val(),

                        'proje': $('select[name=proje]').find('option:selected').val(),

                        'urun': $('select[name=urun]').find('option:selected').val(),

                    },



                    // Maximum file size

                    max_file_size: '10000mb',



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

                    filters: [

                        {title: "Image files", extensions: "jpg,gif,png"},

                        {title: "Zip files", extensions: "zip,avi"}

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

                    flash_swf_url: '{{ config('app.url').'admin/plupload' }}js/Moxie.swf',



                    // Silverlight settings

                    silverlight_xap_url: '{{ config('app.url').'admin/plupload' }}js/Moxie.xap'

                });

            }

            plupLOADget();

            @endif

        @else

        function plupLOADget() {



            $("#uploader").plupload({

                // General settings

                runtimes : 'html5,flash,silverlight,html4',

                url : "{{ route('yonetim.galeri.ekle') }}",

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                multipart_params : {

                    'sayfa': $('select[name=sayfa]').find('option:selected').val(),

                    'proje': $('select[name=proje]').find('option:selected').val(),

                    'urun': $('select[name=urun]').find('option:selected').val(),

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

        @endif

    </script>

@endsection

@section('css')

    <link rel="stylesheet" href="{{ config('app.url') }}css/button-group.css">

@endsection