@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.menu.iliskiler') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="neyle" value="{{ $neyle }}">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <h4 class="heading-ext">Menü İlişkilendir</h4>
                            <div class="uk-form-row">
                                <div style="padding: 30px; text-align: center" class="uk-width-medium-1-1 check">
                                    <span class="icheck-inline">
                                        <label class="css-radio-button">Url ile ilişkilendir
                                            <input {{ $input == NULL ? 'checked' : '' }} name="iliskilendir" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="icheck-inline">
                                        <label class="css-radio-button">Menü ile ilişkilendir
                                            <input {{ $input == 'menu' ? 'checked' : '' }} id="menu" name="iliskilendir" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="icheck-inline">
                                        <label class="css-radio-button">Kategori ile ilişkilendir
                                            <input {{ $input == 'kategori' ? 'checked' : '' }} name="iliskilendir" id="kategori" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="icheck-inline">
                                        <label class="css-radio-button">Proje ile ilişkilendir
                                            <input {{ $input == 'proje' ? 'checked' : '' }} name="iliskilendir" id="proje" type="radio" >
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="icheck-inline">
                                        <label class="css-radio-button">Ürün ile ilişkilendir
                                            <input {{ $input == 'urun' ? 'checked' : '' }} name="iliskilendir" id="urun" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </span>
                                    <span class="uk-form-help-block">İlişki türünü seçiniz...</span>
                                </div>
                            </div>
                            <div style="margin-bottom: 30px" class="uk-form-row">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-large-1-1">
                                        <label>Menü Seçin</label>
                                        <select id="menuler" name="menu">
                                            <option value="0" selected>Menü seçiniz.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom: 30px" class="uk-form-row">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-large-1-1">
                                        <label for="target">Target</label>
                                        <select name="target" id="target" data-md-selectize>
                                            <option selected value="_self">_self</option>
                                            <option value="_blank">_blank</option>
                                            <option value="_parent">_parent</option>
                                            <option value="_top">_top</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-large-1-1">
                                        @if($input == NULL)
                                            <div class="uk-form-row">
                                                <label>Url girin</label>
                                                <input name="url" type="text" class="md-input"  />
                                            </div>
                                        @else
                                            <label>İlişki seçin</label>
                                            <select id="url" name="url">
                                                <option value="0" selected>Önce {{ $input }} ekleyin.</option>
                                            </select>
                                        @endif
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
    <!-- select -->
    <script>
        $.getJSON("{{ route('yonetim.menu.api') }}", function (data) {
            $("#menuler").selectize({
                plugins: {
                    remove_button: {
                        label: ""
                    }
                },
                options: data,
                maxItems: 1,
                valueField: "id",
                labelField: "title",
                searchField: "title",
                create: !1,
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
        $('.check input').on('click', function(){
            id = $(this).attr('id');
            if ( id != undefined ) {
                window.location.href = "{{ route('yonetim.menu.iliskiler', 'data=') }}"+$(this).attr('id');
            } else {
                window.location.href = "{{ route('yonetim.menu.iliskiler') }}";
            }
        });
        $.getJSON("{{ route('yonetim.menu.api', 'data='.$input) }}", function (data) {
            $("#url").selectize({
                plugins: {
                    remove_button: {
                        label: ""
                    }
                },
                options: data,
                maxItems: 1,
                valueField: "id",
                labelField: "title",
                searchField: "title",
                create: !1,
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
@endsection
@section('css')
    <link rel="stylesheet" href="{{ config('app.url') }}css/button-group.css">
@endsection