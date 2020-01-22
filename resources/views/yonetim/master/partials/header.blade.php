<header id="header_main">
    <div class="header_main_content">
        <nav class="uk-navbar">

            <!-- main sidebar switch -->
            <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                <span class="sSwitchIcon"></span>
            </a>

            <!-- secondary sidebar switch -->
            <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                <span class="sSwitchIcon"></span>
            </a>

            <div class="uk-navbar-flip">
                <ul class="uk-navbar-nav user_actions">
                    <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
                    <li><a target="blank" href="{{ route('anasayfa') }}" class="user_action_icon"><i class="material-icons md-24 md-light">http</i></a></li>
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge">{{ \App\Models\Yorumlar::where('visible', 0)->count() }}</span></a>
                        <div class="uk-dropdown uk-dropdown-xlarge">
                            <div class="md-card-content">
                                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                    <li class="uk-width-1-1 uk-active"><a href="#" class="js-uk-prevent uk-text-small">({{ \App\Models\Yorumlar::where('visible', 0)->count() }}) Uyarı</a></li>
                                </ul>
                                <ul id="header_alerts" class="uk-switcher uk-margin">
                                    @if ( \App\Models\Yorumlar::where('visible', 0)->count() == 0 )
                                        Mesajınız Yok
                                    @else
                                        Onaylanmamış mesajları lütfen <a href="{{ route('yonetim.yorum.listele') }}">onaylayın</a>
                                        <br>
                                        <ul style="display: block !important;">
                                        <?php
                                            $yorumlar = \App\Models\Yorumlar::where('visible', 0)->get();
                                            foreach ($yorumlar as $i => $yorum) {
                                                echo '<li>'.' '.$yorum->name.' <a href="'.route("yonetim.yorum.duzenle", $yorum->id).'" style="color: green; font-weight: 700">/Onayla</a>'.'</li>';
                                            }
                                        ?>
                                        </ul>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class="user_action_image"><img class="md-user-image" src="{{ config('app.url').'admin/' }}assets/img/avatars/avatar_11_tn.png" alt=""/></a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                <li><a href="{{ route('yonetim.anasayfa') }}">{{ auth()->guard('yonetim')->user()->adsoyad }}</a></li>
                                <li><a href="{{ route('yonetim.anasayfa') }}">Ayarlar</a></li>
                                <li><a href="{{ route('yonetim.oturumkapat') }}">Çıkış</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="header_main_search_form">
        <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
        <form class="uk-form">
            <input type="text" class="header_main_search_input" />
            <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i></button>
        </form>
    </div>
</header>