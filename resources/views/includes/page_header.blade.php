<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $siteUrl  = rtrim(config('app.url'), '/');
        $siteName = 'Panasia Group';
        $locale   = app()->getLocale();

        /* ── Per-page meta ── */
        $pageMeta = [
            'home'        => ['title' => 'Panasia Group | Energy, Investment & Commodity Trading',           'desc' => 'Panasia Group is a leading commodity trading and logistics company operating across Central Asia, the Caspian region, and beyond — specialising in petroleum, gas, coal and petrochemicals.'],
            'about'       => ['title' => 'About Us | Panasia Group',                                          'desc' => 'Learn about Panasia Group — our history, corporate structure, values, and operational footprint across 11+ countries in Central Asia and the Caspian region.'],
            'services'    => ['title' => 'Trading Services | Panasia Group',                                  'desc' => 'Panasia offers end-to-end commodity trading services: sourcing, logistics, trade finance, quality control, and regulatory compliance across 7+ jurisdictions.'],
            'partners'    => ['title' => 'Our Partners | Panasia Group',                                      'desc' => 'Panasia partners with leading energy companies — SOCAR, ADNOC, KazMunaiGas, CNPC, Mercuria, Vitol, Trafigura, Glencore and more.'],
            'contacts'    => ['title' => 'Contact Us | Panasia Group',                                        'desc' => 'Get in touch with Panasia Group. Offices in Dubai, Tashkent and across Central Asia. Reach our trading desk for commodity supply and partnership enquiries.'],
            'fuel-retail' => ['title' => 'Fuel Retail Network | Panasia Group',                               'desc' => 'Panasia is expanding its fuel retail network across Central Asia — branded stations delivering quality petroleum products under the PANASIA brand.'],
            'logistics'   => ['title' => 'Logistics & Infrastructure | Panasia Group',                        'desc' => 'Panasia operates storage terminals, pipeline access, and multi-modal transport corridors across the Caspian region and Central Asia.'],
            'investment'  => ['title' => 'Investment | Panasia Group',                                        'desc' => 'Explore investment opportunities with Panasia Group across energy infrastructure, commodity trading, and downstream retail in Central Asia.'],
            'geography'   => ['title' => 'Geography of Operations | Panasia Group',                           'desc' => 'Panasia is active in 11+ countries including Uzbekistan, Kazakhstan, Turkmenistan, Azerbaijan, Turkey, Russia, China and more.'],
            'upstream'    => ['title' => 'Upstream Operations | Panasia Group',                               'desc' => 'Panasia\'s upstream segment covers direct sourcing from producers in Uzbekistan, Kazakhstan, Turkmenistan, and the broader Caspian basin.'],
            'refinery'    => ['title' => 'Refinery & Processing | Panasia Group',                             'desc' => 'Panasia works with refineries and processing facilities to supply high-quality petroleum products and petrochemicals across Central Asia.'],
            'projects'    => ['title' => 'Projects | Panasia Group',                                          'desc' => 'Overview of Panasia\'s infrastructure, trading, and downstream projects across the Central Asian energy sector.'],
        ];

        $currentMeta  = $pageMeta[$sel] ?? $pageMeta['home'];
        $pageTitle    = $currentMeta['title'];
        $pageDesc     = $currentMeta['desc'];
        $canonicalUrl = $siteUrl . request()->getPathInfo();
        $ogImage      = $siteUrl . '/assets/public/images/logopan.jpg';
    @endphp

    <title>@include('includes.title')</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/public/images/pancion.png">
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="{{ $siteName }}">
    <meta property="og:title"       content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url"         content="{{ $canonicalUrl }}">
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height"content="630">
    <meta property="og:locale"      content="{{ $locale === 'ar' ? 'ar_AE' : 'en_US' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image"       content="{{ $ogImage }}">

    {{-- hreflang --}}
    <link rel="alternate" hreflang="en" href="{{ $siteUrl }}/en{{ request()->getPathInfo() }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">

    {{-- JSON-LD: Organization --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Panasia Group",
        "url": "{{ $siteUrl }}",
        "logo": "{{ $siteUrl }}/assets/public/images/logo.svg",
        "description": "Leading commodity trading and logistics company specialising in petroleum, gas, coal and petrochemicals across Central Asia and the Caspian region.",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Dubai",
            "addressCountry": "AE"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+971-4-553-4197",
            "contactType": "customer service",
            "areaServed": ["UZ","KZ","TM","AZ","TR","AE","CN","RU","GR","RO","GE"],
            "availableLanguage": ["English"]
        },
        "sameAs": []
    }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/public/css/style.css') }}">

   @if ($sel == 'home')
<div id="pre">
    <div id="pre-grid"></div>
    <div id="pre-glow"></div>

    <div id="pre-logo-wrap">
        <img src="{{ asset('assets/public/images/logo-2.svg') }}"
             alt="Panasia Group" id="pre-logo">
        <p id="pre-tag">Energy &nbsp;&middot;&nbsp; Investment &nbsp;&middot;&nbsp; Growth</p>
    </div>

    <div id="pre-count">
        <span id="pre-num">0</span><span id="pre-sym">%</span>
    </div>

    <div id="pre-bar-wrap"><div id="pre-bar"></div></div>
</div>

<style>
    #pre {
        position: fixed; inset: 0; z-index: 99999;
        background: #020C1A;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    #pre-grid {
        position: absolute; inset: 0; pointer-events: none;
        background-image: radial-gradient(rgba(34,119,187,0.11) 1px, transparent 1px);
        background-size: 46px 46px;
        opacity: 0;
    }
    #pre-glow {
        position: absolute; inset: 0; pointer-events: none;
        background: radial-gradient(ellipse 60% 55% at 50% 50%,
            rgba(34,119,187,0.09) 0%, transparent 65%);
    }
    /* Logo wrapper: clip-path wipe-in from top, initially hidden */
    #pre-logo-wrap {
        position: relative; z-index: 2;
        clip-path: inset(0% 0% 100% 0%);
        text-align: center;
    }
    #pre-logo {
        width: min(220px, 55vw); height: auto;
        filter: brightness(0) invert(1);
        display: block;
    }
    #pre-tag {
        margin: 14px 0 0;
        font-family: 'Montserrat', sans-serif; font-size: 7px; font-weight: 600;
        letter-spacing: 0.32em; text-transform: uppercase;
        color: rgba(255,255,255,0.18);
    }
    #pre-count {
        position: absolute; bottom: 40px; right: 44px; z-index: 2;
        display: flex; align-items: baseline; gap: 3px;
        font-family: 'Montserrat', sans-serif; font-weight: 700;
        line-height: 1; letter-spacing: 0.04em;
        opacity: 0;
    }
    #pre-num { font-size: clamp(0.9rem, 1.8vw, 1.1rem); color: rgba(255,255,255,0.55); }
    #pre-sym { font-size: clamp(0.75rem, 1.4vw, 0.9rem); color: rgba(255,255,255,0.25); font-weight: 600; }

    #pre-bar-wrap {
        position: absolute; bottom: 0; left: 0;
        width: 100%; height: 2px;
        background: rgba(255,255,255,0.04);
        overflow: hidden;
    }
    #pre-bar {
        height: 100%; width: 0%;
        background: linear-gradient(90deg, #2277BB 0%, #FF7C10 100%);
        will-change: width;
    }

    /* Keep body scroll locked while loader is active */
    body.pre-loading { overflow: hidden; }
</style>

<script>
(function () {
    document.body.classList.add('pre-loading');

    var numEl   = document.getElementById('pre-num');
    var loaded  = false;   /* window 'load' has fired        */
    var barDone = false;   /* entrance animation has finished */

    /*
     * EXIT TIMELINE — paused until BOTH gates are open.
     * This guarantees the loader stays visible until the page
     * is genuinely ready AND the entrance animation has played.
     */
    var tlExit = gsap.timeline({
        paused    : true,
        onComplete: function () {
            document.getElementById('pre').style.display = 'none';
            document.body.classList.remove('pre-loading');
        }
    })
    /* Logo clips back upward (reverse of entrance) */
    .to('#pre-logo-wrap', { clipPath: 'inset(100% 0% 0% 0%)', duration: 0.38, ease: 'power2.in' })
    .to('#pre-count',     { opacity: 0, duration: 0.22, ease: 'power2.in' }, '<')
    .to('#pre-grid',      { opacity: 0, duration: 0.20 }, '<0.06')
    .to('#pre',           { yPercent: -100, duration: 0.80, ease: 'expo.inOut' }, '+=0.05');

    function tryExit() {
        if (loaded && barDone) tlExit.play();
    }

    /* ── ENTRANCE ── */
    gsap.timeline()
        .to('#pre-grid',      { opacity: 1, duration: 0.55, ease: 'power2.out' }, 0)
        .to('#pre-count',     { opacity: 1, duration: 0.50, ease: 'power2.out' }, 0.12)
        /* Logo wipes in from top (clip-path reveal) */
        .to('#pre-logo-wrap', { clipPath: 'inset(0% 0% 0% 0%)', duration: 0.70, ease: 'power3.out' }, 0.22)
        .to('#pre-bar',       { width: '100%', duration: 1.15, ease: 'power2.inOut' }, 0.20)
        /* Gate 1: entrance animation finished */
        .call(function () { barDone = true; tryExit(); });

    /* ── COUNTER (synced to bar duration) ── */
    gsap.to({ n: 0 }, {
        n        : 100,
        duration : 1.15,
        delay    : 0.18,
        ease     : 'power2.inOut',
        onUpdate : function () {
            numEl.textContent = Math.round(this.targets()[0].n);
        }
    });

    /* ── Gate 2: full page load ── */
    if (document.readyState === 'complete') {
        /* Already loaded (e.g. hard-cached page) */
        loaded = true;
    } else {
        window.addEventListener('load', function () {
            loaded = true;
            tryExit(); /* may trigger exit immediately if bar is already done */
        });
    }
}());
</script>
@endif
    
</head>