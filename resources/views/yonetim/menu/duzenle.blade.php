<form class="uk-form-stacked" action="{{ route('yonetim.menu.duzenle', $gelen->id) }}" method="post">
    {{ csrf_field() }}
    <div class="uk-width-medium-1-1">
        <h4 class="heading-ext">Menü Güncelle</h4>
        <div class="uk-form-row">
            <div class="parsley-row">
                <select class="md-input" name="belong" id="val_select" required data-md-selectize>
                    <option value="0">-- Üst Menü Yok --</option>
                    @foreach($kategoriler as $kategori)
                        <option {{ $gelen->belong == $kategori->id ? 'selected' : '' }} value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="uk-form-row">
            <label>Menü Adı</label>
            <input name="name" value="{{ $gelen->name }}" type="text" class="md-input"  />
        </div>
    </div>
    <div class="uk-modal-footer uk-text-right">
        <a class="md-btn md-btn-flat uk-modal-close">Çıkış</a>
        <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save">Güncelle</button>
    </div>
</form>