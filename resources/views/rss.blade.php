@php $versiyon @endphp
<rss version="2.0">
    <channel>
        <title>{{ config('ayarlar.baslik') }}</title>
        <link>{{ route('anasayfa') }}</link>
        <description>{{ config('ayarlar.keywords') }}</description>
        @foreach($menuler as $i => $menu)
            <item>
                <title>{{ config('ayarlar.baslik').' | '.$menu->name }}</title>
                <link>{{ route('icerik', $menu->slug) }}</link>
                <description>{{ config('ayarlar.description').' '.$menu->name }}</description>
            </item><!-- page link {{ $i }} -->
        @endforeach
        @foreach($urunler as $i => $urun)
            <item>
                <title>{{ $urun->name }}</title>
                <link>{{ route('proje', $urun->slug) }}</link>
                <description>{{ config('ayarlar.description').' '.$urun->name }}</description>
            </item><!-- project link {{ $i }} -->
        @endforeach
    </channel>
</rss>