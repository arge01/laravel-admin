@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <h4 class="heading-ext">Takvim</h4>
                        <div id="calendar_selectable"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <!-- fullcalendar -->
    <script src="{{ config('app.url').'admin/' }}bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <!--  calendar functions -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.getJSON("{{ route('yonetim.takvim.api') }}", function (data) {
            altair_fullcalendar.calendar_selectable(data)
        }),
            altair_fullcalendar = {
                calendar_selectable: function (data) {
                    var t = $("#calendar_selectable")
                        , a = $('<div id="calendar_colors_wrapper"></div>')
                        , e = altair_helpers.color_picker(a).prop("outerHTML");
                    t.length && t.fullCalendar({
                        header: {
                            left: "title today",
                            center: "",
                            right: "month,agendaWeek,agendaDay prev,next"
                        },
                        buttonIcons: {
                            prev: "md-left-single-arrow",
                            next: "md-right-single-arrow",
                            prevYear: "md-left-double-arrow",
                            nextYear: "md-right-double-arrow"
                        },
                        buttonText: {
                            today: " ",
                            month: " ",
                            week: " ",
                            day: " "
                        },
                        aspectRatio: 2.1,
                        defaultDate: moment(),
                        selectable: !0,
                        selectHelper: !0,
                        select: function (a, r) {
                            UIkit.modal.prompt('<h3 class="heading_b uk-margin-medium-bottom">Yeni Oluştur</h3><div class="uk-margin-medium-bottom" id="calendar_colors">Renk Seçiniz:' + e + "</div>Mesaj Giriniz:", "", function (e) {
                                if ("" !== $.trim(e)) {
                                    var o, d = $("#calendar_colors_wrapper").find("input").val();
                                    o = {
                                        title: e,
                                        start: a,
                                        end: r,
                                        color: d ? d : ""
                                    },
                                        t.fullCalendar("renderEvent", o, !0),
                                        t.fullCalendar("unselect")
                                }
                                data = {
                                    data: [
                                        {
                                            'title': e,
                                            'start': o.start['_d'],
                                            'end': o.end['_d'],
                                            'color': o.color,
                                        },
                                        {title: e},
                                        {start: o.start['_d']},
                                        {end: o.end['_d']},
                                        {color: o.color},
                                    ]
                                };
                                func(data);
                            }, {
                                labels: {
                                    Ok: "Ekle",
                                    Cancel: "Çıkış"
                                }
                            })
                        },
                        editable: !0,
                        eventLimit: !0,
                        timeFormat: "(HH)(:mm)",
                        eventClick: function(event) {
                            deleted(event['id']);
                        },
                        events: [
                        @foreach($takvimler as $i => $takvim)
                            {
                                id: "{{ $takvim->id }}",
                                title: "{{ $takvim->title }}",
                                start: "{{ $takvim->year.'-'.$takvim->startmonth.'-'.$takvim->startday }}",
                                end: "{{ $takvim->year.'-'.$takvim->endmonth.'-'.$takvim->endday }}",
                                color: "{{ $takvim->color }}",
                            },
                        @endforeach
                        ]
                    })
                }
            };
        function func(data) {
            $.ajax({
                type: 'POST',
                url: '{{ route('yonetim.takvim.takvim') }}',
                data: data,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    swal({
                        title: 'Not başarıyla eklendi!',
                        html: 'Lütfen bekleyin yönlendiriliyorsunuz...',
                        timer: 1500,
                        onOpen: () => {
                            swal.showLoading()
                            timerInterval = setInterval(() => {
                                swal.getContent().querySelector('strong')
                                    .textContent = swal.getTimerLeft()
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        window.location.href = "{{ route('yonetim.takvim.takvim') }}";
                    })
                },
                error: function (data) {
                    console.log(data);
                }

            });
        }
        function deleted(ID) {
            swal({
                title: 'Bu notu',
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
                url: '{{ route('yonetim.takvim.sil') }}',
                data: {
                    ID: ID
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    swal({
                        title: 'Not başarıyla silindi!',
                        html: 'Lütfen bekleyin yönlendiriliyorsunuz...',
                        timer: 1500,
                        onOpen: () => {
                            swal.showLoading()
                            timerInterval = setInterval(() => {
                                swal.getContent().querySelector('strong')
                                    .textContent = swal.getTimerLeft()
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        window.location.href = "{{ route('yonetim.takvim.takvim') }}";
                    })
                },
                error: function (data) {
                    console.log(data);
                    swal({
                        type: 'error',
                        title: 'Hata...',
                        text: 'Not Silinirken Hata Oluştu!',
                        confirmButtonText: 'Tamam'
                    });
                }

            });
        }
    </script>
    <script src='{{ config('app.url').'admin/' }}assets/js/pages/lang-all.js'></script>
    <script>
        $(function () {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if (Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>
    <script>
        $(function () {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $body = $('body');


            $switcher_toggle.click(function (e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function (e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $body
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')
                    .addClass(this_theme);

                if (this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // hide style switcher
            $document.on('click keyup', function (e) {
                if ($switcher.hasClass('switcher_active')) {
                    if (
                        (!$(e.target).closest($switcher).length)
                        || (e.keyCode == 27)
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if (localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme=' + localStorage.getItem("altair_theme") + ']').click();
            }


            // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if ((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function (event) {
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function (event) {
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });


            // toggle boxed layout

            // change input's state to checked if mini sidebar is active
            if ((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            // toggle mini sidebar
            $boxed_layout_toggle
                .on('ifChecked', function (event) {
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function (event) {
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });


        });
    </script>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ config('app.url').'admin/' }}bower_components/fullcalendar/dist/fullcalendar.min.css">
@endsection