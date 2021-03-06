@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <h4 class="heading_c uk-margin-small-bottom">Sliderlar</h4>
        <div id="dragula_sortable" class="sortable uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3" data-uk-grid-margin>
            @foreach($data as $dd)
            <li id="{{ $dd->id }}">
                <div class="md-card">
                    <div class="md-card-head head_background" style="background-image: url('{{ config("app.url").'images/'.$dd->img }}')"></div>
                    <div class="md-card-content"><h4>{{ $dd->name }}</h4>.</div>
                </div>
            </li>
            @endforeach
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ config('app.url').'admin/' }}assets/js/ui-editors.js"></script>
    <!-- dragula.js -->
    <script src="{{ config('app.url').'admin/' }}bower_components/dragula.js/dist/dragula.min.js"></script>

    <!--  sortable functions -->
    <script src="{{ config('app.url').'admin/' }}assets/js/pages/components_sortable.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.sortable').sortable({
            stop:function () {
                $.map( $(this).find('li'),function (el) {
                    var itemID = el.id;
                    var itemINdex = $(el).index();
                    var data = {
                        'id': itemID,
                        'sortable': itemINdex
                    };
                    if ( data['id'] != "") {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('yonetim.sortable.slider') }}',
                            data: data,
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        })
                    }
                });
            }
        });
    </script>
@endsection