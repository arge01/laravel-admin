<div style="display: {{ request()->is('/') || request()->is('index.html') ? '' : 'none' }}" class="social-media">
    <div class="line"></div>
    <ul>
        <li><a href="{{ config("ayarlar.facebook") }}"><i class="fa fa-facebook"></i></a></li>
        <li><a href="{{ config("ayarlar.facebook") }}"><i class="fa fa-twitter"></i></a></li>
        <li><a href="{{ config("ayarlar.facebook") }}"><i class="fa fa-instagram"></i></a></li>
        <li><a href="{{ config("ayarlar.facebook") }}"><i class="fa fa-youtube-play"></i></a></li>
    </ul>
    <div class="line"></div>
    <div class="clear"></div>
</div><!-- and media -->