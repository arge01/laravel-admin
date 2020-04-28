@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.anasayfa') }}" method="post">
        {{ csrf_field() }}
        <div id="page_content_inner">
            <h3 class="heading_b uk-margin-bottom">Site Ayarları</h3>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1">
                            <h4 class="heading-ext">Sosyal Medya Ayarları</h4>
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-4">
                                <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-facebook-official"></i>
                                        </span>
                                    <label>Facebook</label>
                                    <input type="text" class="md-input" name="facebook" value="{{ config('ayarlar.facebook') }}"/>
                                </div>
                                <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-twitter"></i>
                                        </span>
                                    <label>Twitter</label>
                                    <input type="text" class="md-input" name="twitter" value="{{ config('ayarlar.twitter') }}"/>
                                </div>
                                <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-instagram"></i>
                                        </span>
                                    <label>Instagram</label>
                                    <input type="text" class="md-input" name="instagram" value="{{ config('ayarlar.instagram') }}"/>
                                </div>
                                <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            <i class="md-list-addon-icon uk-icon-youtube"></i>
                                        </span>
                                    <label>Youtube</label>
                                    <input type="text" class="md-input" name="youtube" value="{{ config('ayarlar.youtube') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <h4 class="heading-ext">Site Ayarları</h4>
                            <div class="uk-form-row">
                                <label>Site Adı <span class="req">*</span></label>
                                <input required type="text" class="md-input" name="baslik" value="{{ config('ayarlar.baslik') }}" />
                            </div>
                            <div class="uk-form-row">
                                <label>Site Başlığı <span class="req">*</span></label>
                                <input required type="text" class="md-input" name="description" value="{{ config('ayarlar.description') }}" />
                            </div>
                            <div class="md-select uk-form-row">
                                <label class="select-label" for="product_edit_tags_control">Site Anahtarları <span class="req">*</span></label>
                                <select id="product_edit_tags_control" multiple name="keywords[]">
                                    @for( $i = 0; $i < count($keyword); $i++ )
                                        <option selected value="{!! $keyword[$i] !!}">{!! $keyword[$i] !!}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="uk-form-row">
                                <label>* Site Kurucusu</label>
                                <input name="author" type="text" class="md-input" value="{{ config('ayarlar.author') }}" disabled/>
                            </div>
                            <div class="uk-form-row">
                                <label>SSL Ayarları</label>
                                <input name="ssl" data-id="{{ config('ayarlar.ssl') }}" type="checkbox" data-switchery data-switchery-color="#7cb342" {{ config('ayarlar.ssl') == 'on' ? 'checked' : '' }} class="switch" />
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <h4 class="heading-ext">İletişim Ayarları</h4>
                            <div class="uk-form-row">
                                <label>E-mail</label>
                                <input type="text" class="md-input" name="mail" value="{{ config('ayarlar.mail') }}" />
                            </div>
                            <div class="uk-form-row">
                                <label>Telefon</label>
                                <input type="text" class="md-input" name="tel" value="{{ config('ayarlar.tel') }}" />
                            </div>
                            <div class="uk-form-row">
                                <label>Adres</label>
                                <textarea name="adres" class="md-input" cols="10" rows="8" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-validation-threshold="10">{{ config('ayarlar.adres') }}</textarea>
                            </div>
                            <div class="uk-form-row">
                                <label>Maps</label>
                                <textarea name="map" class="md-input" cols="10" rows="8" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-validation-threshold="10">{{ config('ayarlar.map') }}</textarea>
                            </div>
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
    </form>
@endsection
@section('javascript')
    <!-- page specific plugins -->
    <!-- d3 -->
    <script src="{{ config('app.url').'admin/' }}bower_components/d3/d3.min.js"></script>
    <!-- metrics graphics (charts) -->
    <script src="{{ config('app.url').'admin/' }}bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
    <!-- chartist (charts) -->
    <script src="{{ config('app.url').'admin/' }}bower_components/chartist/dist/chartist.min.js"></script>
    <!-- maplace (google maps) -->
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="{{ config('app.url').'admin/' }}bower_components/maplace.js/src/maplace-0.1.3.js"></script>
    <!-- peity (small charts) -->
    <script src="{{ config('app.url').'admin/' }}bower_components/peity/jquery.peity.min.js"></script>
    <!-- easy-pie-chart (circular statistics) -->
    <script src="{{ config('app.url').'admin/' }}bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
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
    <script>
        $(document).ready(function(){
            $('.md-select').trigger('click');
        });
        $('html').on('click', function () {
            if ( $('#product_edit_tags_control').find('option:selected').val() == undefined ) {
                $('.select-label').css({'top': '25px', 'font-size': '14px'});
            }
        });
        $('.md-select').on('click', function (event) {
            event.stopPropagation();
            $('.select-label').css({'top': '0', 'font-size': '12px'});
        });
    </script>

    <!-- extanded javascript -->
    <script>
        $(function() {
            altair_product_edit.init()
        }),
            altair_product_edit = {
                init: function() {
                    altair_product_edit.edit_form(),
                        altair_product_edit.product_tags()
                },
                edit_form: function() {
                    var t = $("#product_edit_form")
                        , i = $("#product_edit_submit")
                        , e = $("#product_edit_name")
                        , n = $("#product_edit_name_control")
                        , o = $("#product_edit_sn")
                        , d = $("#product_edit_sn_control")
                        , r = $("#product_edit_manufacturer_control")
                        , u = $("#product_edit_color_control")
                        , c = $("#product_edit_memory_control")
                        , l = function() {
                        return e.text(r.val() + " " + n.val() + ", " + c.val() + ", " + u.val())
                    };
                    n.on("keyup", function() {
                        l()
                    }),
                        r.on("keyup", function() {
                            l()
                        }),
                        d.on("keyup", function() {
                            o.text(d.val())
                        }),
                        u.on("change", function() {
                            l()
                        }),
                        c.on("change", function() {
                            l()
                        }),
                        i.on("click", function(i) {
                            i.preventDefault();
                            var e = JSON.stringify(t.serializeObject(), null, 2);
                            UIkit.modal.alert("<p>Product data:</p><pre>" + e + "</pre>")
                        })
                },
                product_tags: function() {
                    $("#product_edit_tags_control").selectize({
                        plugins: {
                            remove_button: {
                                label: ""
                            }
                        },
                        options: [{
                        }],
                        render: {
                            option: function(t, i) {
                                return '<div class="option"><span>' + i(t.title) + "</span></div>"
                            },
                            item: function(t, i) {
                                return '<div class="item">' + i(t.title) + "</div>"
                            }
                        },
                        maxItems: null,
                        valueField: "value",
                        labelField: "title",
                        searchField: "title",
                        create: !0,
                        onDropdownOpen: function(t) {
                            t.hide().velocity("slideDown", {
                                begin: function() {
                                    t.css({
                                        "margin-top": "0"
                                    })
                                },
                                duration: 200,
                                easing: easing_swiftOut
                            })
                        },
                        onDropdownClose: function(t) {
                            t.show().velocity("slideUp", {
                                complete: function() {
                                    t.css({
                                        "margin-top": ""
                                    })
                                },
                                duration: 200,
                                easing: easing_swiftOut
                            })
                        }
                    })
                }
            };
    </script>
@endsection