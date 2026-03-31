<div class="noise-overlay"></div>
<div class="cursor-dot"></div>
<div class="cursor-outline"></div>
<div class="scroll-progress"></div>

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $currentLocale = app()->getLocale();
    $shortCodes = [
        'en' => 'EN',
    ];
    $currentLabel = $shortCodes[$currentLocale] ?? strtoupper($currentLocale);
@endphp

{{-- ─── TOP BAR ─────────────────────────────────────── --}}
<div class="nav-topbar">
    <div class="ntb-inner">
        <span class="ntb-tagline">{{ p_lang('nav_topbar_tagline') }}</span>
        <div class="ntb-contacts">
            <a href="mailto:{{ p_lang('nav_topbar_email') }}" class="ntb-email">{{ p_lang('nav_topbar_email') }}</a>
            <span class="ntb-sep">·</span>
            <a href="tel:+97145534197" class="ntb-email">+971 4 553 4197</a>
        </div>
    </div>
</div>

{{-- ─── FULL-WIDTH NAVBAR ─────────────────────────────── --}}
<nav id="main-nav">
    <a href="/" class="brand">
        <img src="{{ asset('assets/public/images/logo.svg') }}" alt="Panasia Group">
    </a>
    <div class="menu">
        {!! $main_menu !!}
    </div>
    <div class="nav-right">
        {{-- Mobile contact info (visible only on mobile/tablet) --}}
        <div class="nav-mobile-contact">
            <a href="tel:+97145534197" class="nmc-tel">+971 4 553 4197</a>
            <a href="mailto:{{ p_lang('nav_topbar_email') }}" class="nmc-email">{{ p_lang('nav_topbar_email') }}</a>
        </div>
        {{-- Lang Switcher --}}
        <div class="lang-switcher">
            <button class="lang-btn" type="button" aria-label="Language">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>
                <span>{{ $currentLabel }}</span>
                <svg class="lang-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="lang-dropdown">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    @if(!array_key_exists($localeCode, $shortCodes)) @continue @endif
                    @php
                        $label = $shortCodes[$localeCode] ?? strtoupper($localeCode);
                        $isActive = $localeCode === $currentLocale ? 'active' : '';
                        $url = LaravelLocalization::getLocalizedURL($localeCode, null, [], true);
                    @endphp
                    <a href="{{ $url }}" class="lang-opt {{ $isActive }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>
        {{-- CTA --}}
        <a href="/contacts" class="nav-btn">
            <span>{{ p_lang('nav_contact_us') }}</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
        {{-- Hamburger --}}
        <button class="nav-burger" id="navBurger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- ─── MOBILE DRAWER ──────────────────────────────────── --}}
<div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-header">
        <img src="{{ asset('assets/public/images/logo.svg') }}" alt="Panasia Group" class="md-logo">
        <button class="md-close" id="drawerClose" aria-label="Close">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    <div class="mobile-nav-links">
        {!! $menu_mobile !!}
    </div>
    <div class="md-footer">
        <div class="md-contact">
            <a href="tel:+97145534197" class="md-contact-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6.06 6.06l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                +971 4 553 4197
            </a>
            <a href="mailto:{{ p_lang('nav_topbar_email') }}" class="md-contact-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                {{ p_lang('nav_topbar_email') }}
            </a>
        </div>
        <a href="/contacts" class="md-cta">{{ p_lang('nav_contact_us') }}</a>
        <div class="md-lang">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if(!array_key_exists($localeCode, $shortCodes)) @continue @endif
                @php
                    $label = $shortCodes[$localeCode] ?? strtoupper($localeCode);
                    $isActive = $localeCode === $currentLocale ? 'active' : '';
                    $url = LaravelLocalization::getLocalizedURL($localeCode, null, [], true);
                @endphp
                <a href="{{ $url }}" class="md-lang-opt {{ $isActive }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</div>
<div class="drawer-overlay" id="drawerOverlay"></div>

{{-- ─── SIDE SOCIALS + SCROLL TOP ──────────────────────── --}}
<div class="socials">
    <button class="scroll-top" id="scrollTop" aria-label="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"/>
        </svg>
    </button>
    @if(isset($socials) && $socials->isNotEmpty())
        @foreach($socials as $soc)
            @if($soc->options2 == 'linkedin')
            <a href="{{ $soc->options ?: '#' }}" class="social-link" aria-label="{{ _t($soc->title) }}" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24">
                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                </svg>
            </a>
            @endif
        @endforeach
    @endif
</div>

@if($sel == 'home')
{{-- ═══════════════════════════════════════════════════
     HERO SECTION — CINEMATIC
═══════════════════════════════════════════════════ --}}
<section class="hero" id="hero">
    <div class="hero-video">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('assets/public/images/hero.mp4') }}" type="video/mp4">
        </video>
    </div>
    <div class="hero-bg-img" id="heroBg"></div>
    <div class="hero-orb-1" id="heroOrb1"></div>
    <div class="hero-orb-2" id="heroOrb2"></div>
    <div class="hero-nav-grad"></div>

    {{-- Decorative corner marks --}}
    <div class="hero-corner hero-corner-tr"></div>
    <div class="hero-corner hero-corner-bl"></div>

    <div class="hero-container">
        <div class="hero-left">

        

            {{-- Slogan — the dominant visual element --}}
            <h1 class="hero-headline">
                <span class="h-line">
                    <span class="word-clip"><span class="word">ENERGY.</span></span>
                </span>
                <span class="h-line">
                    <span class="word-clip"><span class="word text-blue">INVESTMENT.</span></span>
                </span>
                <span class="h-line">
                    <span class="word-clip"><span class="word text-orange">GROWTH.</span></span>
                </span>
            </h1>

            <p class="hero-desc anim-fade">{!! p_lang('hero_desc_text') !!}</p>

            {{-- CTAs --}}
            <div class="hero-btns anim-fade">
                <a href="/about" class="btn-primary">
                    <span>{{ p_lang('hero_cta_explore') }}</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="/contacts" class="btn-secondary">{{ p_lang('hero_cta_contact') }}</a>
            </div>

            {{-- Stats --}}
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="stat-num">962<sup>K</sup></span>
                    <span class="stat-lbl">{{ p_lang('hero_stat_vol_lbl') }}</span>
                </div>
                <div class="stat-sep"></div>
                <div class="hero-stat">
                    <span class="stat-num">1.3<sup>M</sup></span>
                    <span class="stat-lbl">{{ p_lang('hero_stat_forecast_lbl') }}</span>
                </div>
                <div class="stat-sep"></div>
                <div class="hero-stat">
                    <span class="stat-num">11</span>
                    <span class="stat-lbl">{{ p_lang('hero_stat_countries_lbl') }}</span>
                </div>
                <div class="stat-sep"></div>
                <div class="hero-stat">
                    <span class="stat-num">4</span>
                    <span class="stat-lbl">{{ p_lang('hero_stat_entities_lbl') }}</span>
                </div>
            </div>

        </div>
    </div>
</section>
@endif


<script>
    gsap.registerPlugin(ScrollTrigger);

    /* ─── Lenis Smooth Scroll ─────────────── */
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        touchMultiplier: 0.8
    });
    function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);

    /* ─── Scroll Progress ─────────────────── */
    gsap.to(".scroll-progress", {
        width: "100%", ease: "none",
        scrollTrigger: { trigger: "body", start: "top top", end: "bottom bottom", scrub: 0 }
    });

    /* ─── Initial States ───────────────────── */
    gsap.set("#main-nav .brand",    { opacity: 0, y: -18 });
    gsap.set("#main-nav .menu",     { opacity: 0, y: -12 });
    gsap.set("#main-nav .nav-right",{ opacity: 0, y: -12 });
    gsap.set(".eyebrow-line",  { scaleX: 0, transformOrigin: "left center" });
    gsap.set(".eyebrow-text",  { opacity: 0, x: -12 });
    gsap.set(".word",          { y: "110%" });
    gsap.set(".anim-fade",     { opacity: 0, y: 28 });
    gsap.set(".hero-stat",     { opacity: 0, y: 24 });
    gsap.set(".hero-ticker",   { opacity: 0 });
    gsap.set(".social-link",   { opacity: 0, x: 18 });
    gsap.set(".hero-orb-1",    { opacity: 0, scale: 0.6 });
    gsap.set(".hero-orb-2",    { opacity: 0, scale: 0.6 });

    const hasPreloader = !!document.querySelector('.preloader');
    const introDelay   = hasPreloader ? 2.8 : 0.15;

    const tl = gsap.timeline({ defaults: { ease: "power3.out" }, delay: introDelay });
    tl
        .to(".hero-orb-1", { opacity: 0.7, scale: 1, duration: 2.5, ease: "power2.out" }, 0)
        .to(".hero-orb-2", { opacity: 0.5, scale: 1, duration: 2.5, ease: "power2.out" }, 0.2)
        .to("#main-nav .brand",    { opacity: 1, y: 0, duration: 0.8 }, 0.1)
        .to("#main-nav .menu",     { opacity: 1, y: 0, duration: 0.8 }, 0.2)
        .to("#main-nav .nav-right",{ opacity: 1, y: 0, duration: 0.8 }, 0.3)
        .to(".eyebrow-line", { scaleX: 1, duration: 0.7, ease: "power2.inOut" }, 0.4)
        .to(".eyebrow-text", { opacity: 1, x: 0, duration: 0.6 }, 0.7)
        .to(".word",  { y: "0%", stagger: 0.12, duration: 1.4 }, 0.6)
        .to(".anim-fade",  { opacity: 1, y: 0, stagger: 0.1, duration: 1, ease: "power2.out" }, 1.1)
        .to(".hero-stat",  { opacity: 1, y: 0, stagger: 0.08, duration: 0.8, ease: "power2.out" }, 1.2)
        .to(".social-link",{ x: 0, opacity: 1, stagger: 0.1, duration: 0.7, ease: "back.out(1.5)" }, 1.1)
        .to(".hero-ticker",{ opacity: 1, duration: 0.8 }, 1.4);

    const heroBg = document.getElementById('heroBg');
    if (heroBg) {
        gsap.to(heroBg, { yPercent: 20, ease: "none",
            scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: true } });
    }
    gsap.to("#heroOrb1", { yPercent: -25, scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: 1 } });
    gsap.to("#heroOrb2", { yPercent: -12, scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: 1.2 } });

    /* ─── Custom Cursor ─────────────────── */
    const cursorDot     = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');
    if (cursorDot && cursorOutline) {
        window.addEventListener("mousemove", (e) => {
            gsap.to(cursorDot,     { x: e.clientX, y: e.clientY, duration: 0.05 });
            gsap.to(cursorOutline, { x: e.clientX, y: e.clientY, duration: 0.3, ease: "power2.out" });
        });
        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('mouseenter', () => gsap.to(cursorOutline, { scale: 1.6, borderColor: "rgba(255,124,16,0.5)", duration: 0.25 }));
            el.addEventListener('mouseleave', () => gsap.to(cursorOutline, { scale: 1, borderColor: "rgba(34,119,187,0.35)", duration: 0.25 }));
        });
    }

    const heroEl = document.getElementById('hero');
    if (heroEl) {
        heroEl.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth  - 0.5) * 0.6;
            const y = (e.clientY / window.innerHeight - 0.5) * 0.6;
            gsap.to("#heroOrb1", { x: x * 35,  y: y * 22,  duration: 2,   ease: "power2.out" });
            gsap.to("#heroOrb2", { x: x * -22, y: y * -15, duration: 1.8, ease: "power2.out" });
        });
    }

    /* ─── Nav Scroll State ────────────── */
    ScrollTrigger.create({
        start: "70px top",
        onEnter: () => {
            document.querySelector('#main-nav')?.classList.add('scrolled');
            document.querySelector('.nav-topbar')?.classList.add('hidden');
        },
        onLeaveBack: () => {
            document.querySelector('#main-nav')?.classList.remove('scrolled');
            document.querySelector('.nav-topbar')?.classList.remove('hidden');
        },
    });

    /* ─── Scroll-to-top button ───────── */
    const scrollTopBtn = document.getElementById('scrollTop');
    if (scrollTopBtn) {
        ScrollTrigger.create({
            start: "300px top",
            onEnter:     () => scrollTopBtn.classList.add('visible'),
            onLeaveBack: () => scrollTopBtn.classList.remove('visible'),
        });
    }

    /* ─── Lang Dropdown ──────────────── */
    const langBtn = document.querySelector('.lang-btn');
    if (langBtn) {
        langBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            langBtn.closest('.lang-switcher').classList.toggle('open');
        });
        document.addEventListener('click', () => {
            document.querySelector('.lang-switcher')?.classList.remove('open');
        });
    }

    /* ─── Mobile Drawer ──────────────── */
    const burger  = document.getElementById('navBurger');
    const drawer  = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('drawerOverlay');
    const closeBtn= document.getElementById('drawerClose');

    function openDrawer() {
        drawer?.classList.add('open');
        overlay?.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
        drawer?.classList.remove('open');
        overlay?.classList.remove('open');
        document.body.style.overflow = '';
    }

    burger?.addEventListener('click', openDrawer);
    closeBtn?.addEventListener('click', closeDrawer);
    overlay?.addEventListener('click', closeDrawer);
</script>
