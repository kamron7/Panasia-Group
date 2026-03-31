<x-public-layout>

    <style>
        /* ── PAGE HERO ── */
        .ops-hero {
            min-height: 75vh; padding: 0;
            background: var(--bg-dark);
            position: relative; z-index: 2; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
        }
        .ops-hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background: url('/assets/public/images/ops-hero.jpeg') center/cover no-repeat;
        }
        .ops-hero-bg::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(2,12,26,0.88) 0%, rgba(10,32,64,0.78) 50%, rgba(2,12,26,0.92) 100%);
        }
        .ops-hero::before {
            content: 'TRADE';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-family: var(--font-head); font-size: 28vw; font-weight: 700;
            color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
            letter-spacing: -0.02em; z-index: 2;
        }
        .ops-hero-inner {
            max-width: var(--container); margin: 0 auto;
            display: grid; grid-template-columns: 1fr;
            gap: 60px; align-items: end;
            position: relative; z-index: 3;
            padding: 180px 5% 80px;
        }
        .oh-eyebrow {
            font-family: var(--font-head); font-size: 10px;
            letter-spacing: 0.18em; color: var(--orange);
            margin-bottom: 20px; display: block; text-transform: uppercase;
        }
        .oh-title {
            font-family: var(--font-head);
            font-size: clamp(3.5rem, 8vw, 8rem);
            line-height: 0.92; color: #fff; letter-spacing: -0.03em;
            font-weight: 700; text-transform: uppercase;
        }
        .oh-title .t-blue { color: var(--blue); }

        /* ── OPERATIONS LIST ── */
        .oplist-section {
            padding: 100px 5%;
            background: var(--bg);
        }
        .oplist-inner { max-width: var(--container); margin: 0 auto; }
        .oplist-head {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 60px; padding-bottom: 24px; border-bottom: 1px solid var(--border);
        }
        .oplist-title {
            font-family: var(--font-head); font-size: clamp(1.8rem, 3vw, 2.5rem);
            color: var(--text); letter-spacing: -0.02em;
        }
        .oplist-subtitle {
            font-size: 0.9rem; color: var(--text-muted); max-width: 320px;
            text-align: right; line-height: 1.6;
        }

        .oplist { display: flex; flex-direction: column; }
        .op-item {
            border-bottom: 1px solid var(--border);
            transition: background 0.3s;
            cursor: default;
        }
        .op-item:hover { background: var(--bg-alt); }
        .op-header {
            display: grid;
            grid-template-columns: 80px 1fr 180px 160px 120px;
            align-items: center; gap: 24px;
            padding: 28px 0;
        }
        .op-num {
            font-family: var(--font-head); font-size: 10px;
            color: var(--text-light); letter-spacing: 0.12em;
        }
        .op-name {
            font-family: var(--font-head); font-size: 1.15rem;
            color: var(--text); font-weight: 700;
        }
        .op-region {
            font-size: 0.88rem; color: var(--text-muted);
        }
        .op-commodity {
            display: flex; align-items: center; gap: 8px;
        }
        .op-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--orange); flex-shrink: 0;
        }
        .op-commodity-name { font-size: 0.88rem; color: var(--text-muted); }
        .op-status {
            display: inline-flex; align-items: center;
            padding: 5px 14px; border-radius: 100px;
            font-family: var(--font-head); font-size: 9px;
            letter-spacing: 0.1em; text-transform: uppercase;
        }
        .op-status.active { background: rgba(34,119,187,0.08); color: var(--blue); }
        .op-status.expanding { background: rgba(255,124,16,0.08); color: var(--orange); }

        /* ── REGIONS FEATURE SECTION (Blue) ── */
        .regions-section {
            padding: 120px 5%;
            background: var(--bg-blue);
            position: relative; overflow: hidden;
        }
        .regions-section::before {
            content: 'REGIONS';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-family: var(--font-head); font-size: 22vw; font-weight: 700;
            color: rgba(255,255,255,0.04); white-space: nowrap; pointer-events: none;
        }
        .regions-inner {
            max-width: var(--container); margin: 0 auto;
            position: relative; z-index: 1;
        }
        .regions-top {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 70px;
        }
        .regions-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.2rem);
            color: #fff; font-weight: 700; line-height: 1.1; letter-spacing: -0.02em;
        }
        .regions-desc {
            font-size: 1rem; color: rgba(255,255,255,0.6);
            max-width: 360px; text-align: right; line-height: 1.7;
        }
        .regions-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;
            border-radius: 20px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08);
        }
        .region-block {
            padding: 48px 40px;
            background: rgba(255,255,255,0.05);
            border-right: 1px solid rgba(255,255,255,0.08);
            transition: background 0.3s;
        }
        .region-block:last-child { border-right: none; }
        .region-block:hover { background: rgba(255,255,255,0.1); }
        .rb-num {
            font-family: var(--font-head); font-size: 9px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 16px; display: block;
        }
        .rb-name {
            font-family: var(--font-head); font-size: 1.3rem;
            color: #fff; font-weight: 700; margin-bottom: 14px; line-height: 1.2;
        }
        .rb-desc {
            font-size: 0.9rem; color: rgba(255,255,255,0.55);
            line-height: 1.7; margin-bottom: 24px;
        }
        .rb-tags { display: flex; flex-wrap: wrap; gap: 7px; }
        .rb-tag {
            font-size: 10px; color: rgba(255,255,255,0.6); font-weight: 500;
            padding: 4px 12px; border-radius: 100px;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
        }

        /* ── TRADE ROUTES SECTION (Dark) ── */
        .routes-section {
            padding: 120px 5%;
            background: var(--bg-dark);
            position: relative;
        }
        .routes-inner { max-width: var(--container); margin: 0 auto; }
        .routes-header {
            margin-bottom: 70px;
        }
        .routes-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 14px; display: block;
        }
        .routes-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3rem);
            color: #fff; font-weight: 700; line-height: 1.1; letter-spacing: -0.02em;
        }
        .routes-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;
        }
        .route-card {
            padding: 44px 40px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            transition: all 0.3s;
        }
        .route-card:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.15);
            transform: translateY(-4px);
        }
        .rc-from-to {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 24px;
        }
        .rc-node {
            font-family: var(--font-head); font-size: 11px;
            color: #fff; font-weight: 700; letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .rc-arrow {
            flex: 1; height: 1px; background: rgba(255,255,255,0.15);
            position: relative;
        }
        .rc-arrow::after {
            content: ''; position: absolute; right: -1px; top: -3px;
            width: 6px; height: 6px; border-top: 1px solid rgba(255,255,255,0.3);
            border-right: 1px solid rgba(255,255,255,0.3); transform: rotate(45deg);
        }
        .rc-title {
            font-family: var(--font-head); font-size: 1.2rem;
            color: #fff; margin-bottom: 12px; line-height: 1.2;
        }
        .rc-desc {
            font-size: 0.9rem; color: rgba(255,255,255,0.5);
            line-height: 1.7; margin-bottom: 24px;
        }
        .rc-meta {
            display: flex; gap: 24px;
        }
        .rc-meta-item { display: flex; flex-direction: column; gap: 3px; }
        .rcm-label {
            font-family: var(--font-head); font-size: 9px;
            color: rgba(255,255,255,0.3); letter-spacing: 0.1em; text-transform: uppercase;
        }
        .rcm-val { font-size: 0.88rem; color: rgba(255,255,255,0.7); font-weight: 500; }

        /* ── CTA ── */
        .ops-cta {
            padding: 100px 5%;
            background: var(--bg);
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .ops-cta-inner { max-width: 640px; margin: 0 auto; }
        .ops-cta-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 16px; display: block;
        }
        .ops-cta-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3rem);
            color: var(--text); font-weight: 700; letter-spacing: -0.02em;
            margin-bottom: 20px; line-height: 1.1;
        }
        .ops-cta-desc {
            font-size: 1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 36px;
        }
        .ops-cta-btns { display: flex; gap: 14px; justify-content: center; }

        /* ── Parallax Break ── */
        .parallax-break {
            height: 420px;
            position: relative; overflow: hidden;
        }
        .parallax-break-img {
            position: absolute; top: -25%; left: 0; right: 0; bottom: -25%;
            background: center/cover no-repeat;
            will-change: transform;
        }
        .parallax-break-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, rgba(2,12,26,0.35) 0%, rgba(2,12,26,0.50) 100%);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .op-header { grid-template-columns: 50px 1fr 1fr; }
            .op-region, .op-status { display: none; }
            .regions-grid { grid-template-columns: 1fr; }
            .routes-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .ops-hero-inner { padding: 110px 5% 56px; }
            .oplist-section { padding: 70px 5%; }
            .regions-section { padding: 80px 5%; }
            .routes-section { padding: 80px 5%; }
            .ops-cta { padding: 70px 5%; }
            .oplist-head { flex-direction: column; align-items: flex-start; gap: 12px; }
            .oplist-subtitle { text-align: left; }
            .regions-top { flex-direction: column; align-items: flex-start; gap: 16px; }
            .regions-desc { text-align: left; }
            .ops-cta-btns { flex-direction: column; align-items: center; }
        }
        @media (max-width: 600px) {
            .ops-hero-inner { padding: 96px 5% 44px; }
            .oplist-section { padding: 56px 5%; }
            .regions-section { padding: 60px 5%; }
            .routes-section { padding: 60px 5%; }
            .ops-cta { padding: 56px 5%; }
            .op-header { grid-template-columns: 40px 1fr; }
            .op-commodity { display: none; }
            .oh-title { font-size: clamp(3rem, 13vw, 5rem); }
            .region-block { padding: 32px 24px; }
            .route-card { padding: 32px 28px; }
        }


    </style>

    {{-- HERO --}}
    <section class="ops-hero">
        <div class="ops-hero-bg" id="opsHeroBg"></div>
        <div class="ops-hero-inner">
            <div class="ops-hero-content">
                <span class="oh-eyebrow ops-anim">{{ _t($p['ops_page_eyebrow']->title ?? '') }}</span>
                <h1 class="oh-title ops-anim">
                    {{ _t($p['ops_page_title_line1']->title ?? '') }}<br>
                    <span class="t-blue">{{ _t($p['ops_page_title_line2']->title ?? '') }}</span>
                </h1>
            </div>
        </div>
    </section>

    {{-- OPERATIONS TABLE --}}
    <section class="oplist-section">
        <div class="oplist-inner">
            <div class="oplist-head">
                <h2 class="oplist-title">{{ _t($p['ops_list_title']->title ?? 'Active Operations') }}</h2>
                <p class="oplist-subtitle">
                    {{ _t($p['ops_list_subtitle']->title ?? '') }}
                </p>
            </div>
            <div class="oplist">

                @if(isset($ops_table) && $ops_table->isNotEmpty())
                    @foreach($ops_table as $op)
                    <div class="op-item ops-row">
                        <div class="op-header">
                            <span class="op-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="op-name">{{ _t($op->title) }}</span>
                            <span class="op-region">{{ _t($op->short_content) }}</span>
                            <div class="op-commodity">
                                <div class="op-dot"></div>
                                <span class="op-commodity-name">{{ $op->options }}</span>
                            </div>
                            <span class="op-status {{ $op->options2 }}">{{ ucfirst($op->options2) }}</span>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    {{-- PARALLAX BREAK --}}
    <div class="parallax-break">
        <div class="parallax-break-img" style="background-image:url('/assets/public/images/parallax-ops.jpg');" data-parallax></div>
        <div class="parallax-break-overlay"></div>
    </div>

    {{-- REGIONS SECTION (Blue) --}}
    <section class="regions-section">
        <div class="regions-inner">
            <div class="regions-top">
                <h2 class="regions-title ops-region-anim">
                    {!! _t($p['ops_regions_title']->title ?? 'Three Core<br>Operating Regions') !!}
                </h2>
                <p class="regions-desc ops-region-anim">
                    {{ _t($p['ops_regions_desc']->title ?? '') }}
                </p>
            </div>
            <div class="regions-grid">

                @if(isset($ops_regions) && $ops_regions->isNotEmpty())
                    @foreach($ops_regions as $i => $reg)
                    <div class="region-block ops-rb-anim">
                        <span class="rb-num">{{ _t($p['ops_region_prefix']->title ?? 'Region') }} {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="rb-name">{{ _t($reg->title) }}</div>
                        <p class="rb-desc">{!! _t($reg->content) !!}</p>
                        @if(!empty(_t($reg->short_content)))
                        <div class="rb-tags">
                            @foreach(array_map('trim', explode(',', _t($reg->short_content))) as $tag)
                                <span class="rb-tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    {{-- TRADE ROUTES (Dark) --}}
    <section class="routes-section">
        <div class="routes-inner">
            <div class="routes-header">
                <span class="routes-tag">{{ _t($p['ops_routes_tag']->title ?? 'Infrastructure') }}</span>
                <h2 class="routes-title">{{ _t($p['ops_routes_title']->title ?? 'Key Trade Corridors') }}</h2>
            </div>
            <div class="routes-grid">

                @if(isset($ops_routes) && $ops_routes->isNotEmpty())
                    @foreach($ops_routes as $route)
                    <div class="route-card ops-rc-anim">
                        <div class="rc-from-to">
                            <span class="rc-node">{{ $route->options }}</span>
                            <div class="rc-arrow"></div>
                            <span class="rc-node">{{ $route->options2 }}</span>
                        </div>
                        <h3 class="rc-title">{{ _t($route->title) }}</h3>
                        <p class="rc-desc">{!! _t($route->content) !!}</p>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="ops-cta">
        <div class="ops-cta-inner">
            <span class="ops-cta-tag">{{ _t($p['ops_cta_tag']->title ?? 'Partner With Us') }}</span>
            <h2 class="ops-cta-title">{!! _t($p['ops_cta_title']->title ?? 'Interested in a<br>Trading Partnership?') !!}</h2>
            <p class="ops-cta-desc">
                {{ _t($p['ops_cta_desc']->title ?? '') }}
            </p>
            <div class="ops-cta-btns">
                <a href="/contacts" class="btn-primary">
                    <span>{{ _t($p['btn_contact_our_team']->title ?? 'Contact Our Team') }}</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        /* Hero */
        gsap.fromTo(".ops-anim", { y: 40, opacity: 0 }, {
            y: 0, opacity: 1, duration: 1.1, stagger: 0.18,
            ease: "power3.out", delay: 0.3
        });

        /* Hero bg parallax */
        const opsHeroBg = document.getElementById('opsHeroBg');
        if (opsHeroBg) {
            gsap.to(opsHeroBg, {
                yPercent: 18, ease: 'none',
                scrollTrigger: { trigger: '.ops-hero', start: 'top top', end: 'bottom top', scrub: true }
            });
        }

        /* Parallax image breaks */
        document.querySelectorAll('[data-parallax]').forEach(el => {
            gsap.to(el, {
                yPercent: 22, ease: 'none',
                scrollTrigger: { trigger: el.closest('.parallax-break'), start: 'top bottom', end: 'bottom top', scrub: true }
            });
        });

        /* Operations rows stagger */
        gsap.utils.toArray('.ops-row').forEach((row, i) => {
            gsap.set(row, { opacity: 0, x: -20 });
            ScrollTrigger.create({
                trigger: row, start: "top 88%",
                onEnter: () => gsap.to(row, {
                    opacity: 1, x: 0, duration: 0.7,
                    delay: i * 0.07, ease: "power3.out"
                })
            });
        });

        /* Regions section */
        gsap.utils.toArray('.ops-region-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 28 });
            ScrollTrigger.create({
                trigger: '.regions-section', start: "top 75%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.9,
                    delay: i * 0.14, ease: "power3.out"
                })
            });
        });

        gsap.utils.toArray('.ops-rb-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 30 });
            ScrollTrigger.create({
                trigger: el, start: "top 85%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.85,
                    delay: i * 0.12, ease: "power3.out"
                })
            });
        });

        /* Route cards */
        gsap.utils.toArray('.ops-rc-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: el, start: "top 85%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.85,
                    delay: (i % 2) * 0.13, ease: "power3.out"
                })
            });
        });

        /* CTA */
        gsap.set('.ops-cta-inner', { opacity: 0, y: 30 });
        ScrollTrigger.create({
            trigger: '.ops-cta', start: "top 80%",
            onEnter: () => gsap.to('.ops-cta-inner', { opacity: 1, y: 0, duration: 1, ease: "power3.out" })
        });
    </script>

</x-public-layout>
