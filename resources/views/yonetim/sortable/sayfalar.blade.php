@extends('yonetim.master.master')
@section('content')
    <div id="page_content_inner">
        <h4 class="heading_a">Menüler</h4>
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-1-1">
                <ul class="sortable">
                    @foreach($data as $dd)
                        <li id="{{ $dd->id }}" class="uk-nestable-item">
                            <div class="uk-nestable-panel">
                                <i class="uk-nestable-handle material-icons">&#xE5D2;</i>
                                {{ $dd->name }}
                            </div>
                            <ul class="sortable">
                                @foreach($dd->tablari as $alt_dd)
                                <li id="{{ $alt_dd->id }}" class="uk-nestable-item">
                                    <div class="uk-nestable-panel">
                                        <i class="uk-nestable-handle material-icons">&#xE5D2;</i>
                                        {{ $alt_dd->name }}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ config('app.url').'admin/' }}assets/js/ui-editors.js"></script>
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
                            url: '{{ route('yonetim.sortable.sayfalar') }}',
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