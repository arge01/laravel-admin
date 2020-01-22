<footer id="footer">
    <div class="logo"><img src="{{config('app.url').'img/logo.png'}}"></div>
    <div class="footer-cont">
        <ul>
            @foreach( $menuler as $i => $menu )
            <li id="foot-{{$menu->slug}}" class="{{ 'footer-menu-'.$menu->slug }}"><a target="{{ $menu->target }}" href="{{ $menu->url == NULL ? route('icerik', $menu->slug) : $menu->url }}">{{ $menu->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="social-med">
        <ul>
            <li><a target="_blank" href="{{ config("ayarlar.facebook") }}"><i class="fa fa-facebook"></i></a></li>
            <li><a target="_blank" href="{{ config("ayarlar.twitter") }}"><i class="fa fa-twitter"></i></a></li>
            <li><a target="_blank" href="{{ config("ayarlar.instagram") }}"><i class="fa fa-instagram"></i></a></li>
        </ul>
    </div>
    <div id="footer-and">
        Copyright {{date('Y')}}. All Right Reserved For Kahveland <a target="_blank" class="ext-logo" style="display: inline-block;" href="https://ufrad.org.tr/"><img style="max-height: 65px; margin: 5px;" src="{{config('app.url').'images/urfad.png'}}"></a>
    </div>
</footer><!-- and footer -->
<style>
    #footer-and .ext-logo {
        filter: grayscale(100%); 
        -webkit-filter: grayscale(100%);
    }
    #footer-and .ext-logo:hover {
        filter: grayscale(0); 
        -webkit-filter: grayscale(0);
    }
</style>
