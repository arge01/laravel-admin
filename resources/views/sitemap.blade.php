@php $versiyon @endphp
<urlset>
    @foreach($menuler as $i => $menu)
    <url>
        <loc>{{ route('icerik', $menu->slug) }}</loc>
    </url><!-- page link {{ $i }} -->
    @endforeach
        @foreach($urunler as $i => $urun)
            <url>
                <loc>{{ route('proje', $urun->slug) }}</loc>
            </url><!-- project link {{ $i }} -->
        @endforeach
</urlset>