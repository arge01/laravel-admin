<form class="uk-form-stacked" action="{{ route('yonetim.referans.duzenle', $gelen->id) }}" method="post">
    {{ csrf_field() }}
    <div class="uk-width-medium-1-1">
        <h4 class="heading-ext">Referans Güncelle</h4>
        <div class="uk-form-row">
            <label>Referans Adı</label>
            <input name="url" value="{{ $gelen->url }}" type="text" class="md-input" required />
        </div>
        <div class="uk-form-row">
            <label>Referans Adı</label>
            <input name="name" value="{{ $gelen->name }}" type="text" class="md-input" required />
        </div>
    </div>
    <div class="uk-modal-footer uk-text-right">
        <a class="md-btn md-btn-flat uk-modal-close">Çıkış</a>
        <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save">Güncelle</button>
    </div>
</form>