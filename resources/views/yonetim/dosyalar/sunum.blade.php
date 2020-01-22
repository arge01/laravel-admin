@extends('yonetim.master.master')
@section('content')
    <form action="{{ route('yonetim.dosya.ekstra') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
	    <div id="page_content_inner">
	        <div class="md-card">
	            <div class="md-card-content">
	                <h4 class="heading-ext"><a target="_blank" href="{{ config('app.url').'pdf/pdf.pdf' }}">PDF</a> Dosya Ekle / Düzenle</h4>
	                <div class="uk-form-file md-btn md-btn-primary">
                        Seç (sadece pdf)
                        <input type="file" name="pdf" accept="pdf/*">
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
@endsection