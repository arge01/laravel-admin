<div id="start-nav">
    <nav class="navbar navbar-default navbar-static-top">
        <a href="{{ route('anasayfa') }}" class="logo"><img src="{{ config('app.url') }}img/logo.png"></a>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{ request()->is('/') || request()->is('index.html') ? 'active' : '' }}"><a href="{{ route('anasayfa') }}">ANASAYFA</a></li>
                @foreach( $menuler as $i => $menu )
                    <li id="{{ 'menu-'.$menu->id }}" class="{{ request()->is($menu->slug.'.html') ? 'active' : '' }} {{ count($menu->tablari) > 0 ? 'dropdown' : '' }}">
                        <a id="{{ 'menu-'.$menu->id }}-a"
                           class="{{ count($menu->tablari) > 0 ? 'dropdown-toggle' : '' }}"
                           data-toggle="{{ count($menu->tablari) > 0 ? 'dropdown' : '' }}"
                           href="{{ $menu->id != 2 ? $menu->url == NULL ? config('app.url').$menu->slug.'.html' : $menu->url : '#' }}">
                            {{ $menu->name }}
                            @if ( count($menu->tablari) > 0 )
                                <span class="caret"></span>
                                <ul class="dropdown-menu">
                                    @foreach( $menu->tablari as $b => $tablari )
                                        <li id="{{ 'menu-'.$menu->id.'-'.$b }}" class="{{ request()->is($tablari->slug.'.html') == $tablari->slug.'.html' ? 'active' : '' }}">
                                            @if($menu->slug != $tablari->slug)
                                                <a href="{{ $tablari->url == NULL ? config('app.url').$tablari->slug.'.html' : $tablari->url }}">{{ $tablari->name }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</div><!-- start nav -->