<footer class="footer-section">
    <div class="footer-nav">
        <div class="footer-grid">

            <div class="f-col f-col-brand">
                <img src="{{ asset('assets/public/images/logo.svg') }}" alt="Panasia Group" class="f-brand-logo">
                <p class="f-brand-desc">{{ p_lang('footer_brand_desc') }}</p>
                <div class="f-socials">
                    @if(isset($socials) && $socials->isNotEmpty())
                        @foreach($socials as $soc)
                            @if($soc->options2 == 'linkedin')
                            <a href="{{ $soc->options ?: '#' }}" class="f-social" aria-label="{{ _t($soc->title) }}" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="f-col">
                <h4 class="f-head">{{ p_lang('footer_nav_col') }}</h4>
                <ul class="f-links">
                    <li><a href="/">{{ p_lang('footer_nav_home') }}</a></li>
                    <li><a href="/about">{{ p_lang('footer_nav_about') }}</a></li>
                    <li><a href="/services">{{ p_lang('footer_nav_services') }}</a></li>
                    <li><a href="/projects">{{ p_lang('footer_nav_projects') }}</a></li>
                    <li><a href="/contacts">{{ p_lang('footer_nav_contact') }}</a></li>
                </ul>
            </div>

            <div class="f-col">
                <h4 class="f-head">{{ p_lang('footer_follow_col') }}</h4>
                <ul class="f-links">
                    @if(isset($socials) && $socials->isNotEmpty())
                        @foreach($socials as $soc)
                        <li><a href="{{ $soc->options ?: '#' }}" target="_blank" rel="noopener">{{ _t($soc->title) }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="f-col">
                <h4 class="f-head">{{ p_lang('footer_contact_col') }}</h4>
                <ul class="f-links">
                    <li><a href="mailto:{{ p_lang('nav_topbar_email') }}">{{ p_lang('nav_topbar_email') }}</a></li>
                    <li><a href="tel:+97145534197">+971 4 553 4197</a></li>
                    <li class="f-address">
                        {{ p_lang('footer_address') }}<br>
                        {{ p_lang('footer_address_sub') }}
                    </li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <span>{{ p_lang('footer_copyright') }}</span>
            <span class="f-made-by">{{ p_lang('footer_developed_by') }} : <a href="https://osg.uz" target="_blank" rel="noopener">Online Service Group</a></span>
        </div>
    </div>
</footer>
