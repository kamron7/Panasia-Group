<x-public-layout>

    <style>
        /* ── PAGE HERO ── */
        .svc-hero {
            min-height: 72vh; padding: 0;
            background: var(--bg-dark);
            position: relative; z-index: 2; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
        }
        .svc-hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background: url('/assets/public/images/services-hero.jpg') center/cover no-repeat;
        }
        .svc-hero-bg::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(2,12,26,0.88) 0%, rgba(10,32,64,0.78) 50%, rgba(2,12,26,0.92) 100%);
        }
        .svc-hero::before {
            content: 'TRADE';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-family: var(--font-head); font-size: 26vw; font-weight: 700;
            color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
            letter-spacing: -0.02em; z-index: 2;
        }
        .svc-hero-inner {
            max-width: var(--container); margin: 0 auto;
            position: relative; z-index: 3;
            padding: 180px 5% 80px;
        }
        .sh-eyebrow {
            font-family: var(--font-head); font-size: 10px;
            letter-spacing: 0.18em; color: var(--orange);
            margin-bottom: 20px; display: block; text-transform: uppercase;
        }
        .sh-title {
            font-family: var(--font-head);
            font-size: clamp(3.5rem, 8vw, 8rem);
            line-height: 0.92; color: #fff; letter-spacing: -0.03em;
            font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
        }
        .sh-title .t-blue  { color: var(--blue); }
        .sh-title .t-orange { color: var(--orange); }
        .sh-desc {
            font-size: 1.1rem; color: rgba(255,255,255,0.65); line-height: 1.8;
            max-width: 560px;
        }

        /* ── Parallax Break ── */
        .parallax-break {
            height: 440px;
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

        /* ── COMMODITIES DETAIL SECTION ── */
        .comm-detail-section {
            padding: 120px 5%;
            background: var(--bg);
        }
        .comm-detail-inner { max-width: var(--container); margin: 0 auto; }
        .comm-detail-header {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 70px;
        }
        .cdh-left {}
        .cdh-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 14px; display: block;
        }
        .cdh-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3rem);
            color: var(--text); font-weight: 700; line-height: 1.1; letter-spacing: -0.02em;
        }
        .cdh-desc {
            font-size: 1rem; color: var(--text-muted); max-width: 340px;
            text-align: right; line-height: 1.7;
        }

        /* Commodity feature items */
        .comm-items { display: flex; flex-direction: column; gap: 2px; }
        .comm-feat-item {
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: border-color 0.3s;
        }
        .comm-feat-item:hover { border-color: rgba(34,119,187,0.3); }
        .cfi-header {
            display: grid;
            grid-template-columns: 64px 1fr auto;
            align-items: center; gap: 32px;
            padding: 32px 36px;
            cursor: default;
            transition: background 0.3s;
        }
        .cfi-header:hover { background: var(--bg-alt); }
        .cfi-num {
            font-family: var(--font-head); font-size: 10px;
            color: var(--text-light); letter-spacing: 0.12em;
        }
        .cfi-title-wrap {}
        .cfi-cat {
            font-family: var(--font-head); font-size: 9px;
            color: var(--orange); letter-spacing: 0.16em; text-transform: uppercase;
            margin-bottom: 4px; display: block;
        }
        .cfi-name {
            font-family: var(--font-head); font-size: 1.35rem;
            color: var(--text); font-weight: 700;
        }
        .cfi-badge {
            display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end;
        }
        .cfi-tag {
            font-size: 11px; color: var(--text-muted); font-weight: 500;
            padding: 5px 14px; border-radius: 100px;
            background: var(--bg-alt); border: 1px solid var(--border);
            white-space: nowrap;
        }

        /* Expanded content */
        .cfi-body {
            padding: 0 36px 32px;
            display: grid; grid-template-columns: 1fr 1fr; gap: 40px;
            border-top: 1px solid var(--border);
        }
        .cfi-desc {
            font-size: 1rem; color: var(--text-muted); line-height: 1.8;
            padding-top: 28px;
        }
        .cfi-specs { padding-top: 28px; }
        .cfi-spec-row {
            display: flex; justify-content: space-between;
            padding: 10px 0; border-bottom: 1px solid var(--border);
        }
        .cfi-spec-row:last-child { border-bottom: none; }
        .cfs-key { font-size: 0.85rem; color: var(--text-muted); }
        .cfs-val { font-size: 0.85rem; color: var(--text); font-weight: 600; }

        /* ── SERVICES CAPABILITIES ── */
        .cap-section {
            padding: 120px 5%;
            background: var(--bg-dark);
            position: relative; overflow: hidden;
        }
        .cap-section::before {
            content: 'EDGE';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-family: var(--font-head); font-size: 28vw; font-weight: 700;
            color: rgba(255,255,255,0.025); white-space: nowrap; pointer-events: none;
            letter-spacing: -0.04em;
        }
        .cap-section::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(34,119,187,0.3), transparent);
        }
        .cap-inner {
            max-width: var(--container); margin: 0 auto;
            display: grid; grid-template-columns: 320px 1fr; gap: 100px; align-items: start;
            position: relative; z-index: 1;
        }
        /* ── left sticky column ── */
        .cap-left { position: sticky; top: 120px; }
        .cap-left-tag {
            font-family: var(--font-head); font-size: 9px;
            color: var(--orange); letter-spacing: 0.22em;
            text-transform: uppercase; margin-bottom: 28px;
            display: flex; align-items: center; gap: 12px;
        }
        .cap-left-tag::before { content: ''; display: block; width: 28px; height: 1px; background: var(--orange); flex-shrink:0; }
        .cap-left-title {
            font-family: var(--font-head); font-size: clamp(2rem, 3vw, 2.6rem);
            color: #fff; font-weight: 700; line-height: 1.08; letter-spacing: -0.025em;
            margin-bottom: 24px;
        }
        .cap-left-desc {
            font-size: 0.95rem; color: rgba(255,255,255,0.5); line-height: 1.85;
            margin-bottom: 40px;
        }
        .cap-left-stat {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 28px;
        }
        .cap-stat-num {
            font-family: var(--font-head); font-size: 2.6rem; font-weight: 700;
            color: var(--blue); letter-spacing: -0.04em; line-height: 1;
            margin-bottom: 6px;
        }
        .cap-stat-lbl { font-size: 0.8rem; color: rgba(255,255,255,0.4); }
        /* ── cards grid ── */
        .cap-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1px; background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.07);
        }
        .cap-card {
            padding: 44px 36px;
            background: var(--bg-dark);
            position: relative; overflow: hidden;
            transition: background 0.35s;
        }
        .cap-card:hover { background: rgba(255,255,255,0.025); }
        .cap-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--blue), var(--orange));
            transform: scaleX(0); transform-origin: left; transition: transform 0.45s ease;
        }
        .cap-card:hover::before { transform: scaleX(1); }
        .cap-card-num {
            position: absolute; top: 20px; right: 24px;
            font-family: var(--font-head); font-size: 3.5rem; font-weight: 700;
            color: rgba(255,255,255,0.04); line-height: 1; letter-spacing: -0.06em;
            pointer-events: none; user-select: none;
        }
        .cap-card-icon {
            width: 46px; height: 46px;
            background: linear-gradient(135deg, rgba(34,119,187,0.25) 0%, rgba(34,119,187,0.08) 100%);
            border: 1px solid rgba(34,119,187,0.3);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            color: #5ba8e0; margin-bottom: 22px;
            transition: border-color 0.3s, background 0.3s;
        }
        .cap-card:hover .cap-card-icon {
            background: linear-gradient(135deg, rgba(34,119,187,0.35) 0%, rgba(34,119,187,0.15) 100%);
            border-color: rgba(34,119,187,0.5);
        }
        .cap-card-title {
            font-family: var(--font-head); font-size: 1.05rem; font-weight: 700;
            color: #fff; margin-bottom: 10px; letter-spacing: -0.01em; line-height: 1.2;
        }
        .cap-card-desc {
            font-size: 0.875rem; color: rgba(255,255,255,0.42); line-height: 1.75;
        }

        /* ── WHY US SECTION (Alt bg) ── */
        .why-trading-section {
            padding: 120px 5%;
            background: var(--bg-alt);
        }
        .wts-inner { max-width: var(--container); margin: 0 auto; }
        .wts-header { margin-bottom: 64px; }
        .wts-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 14px; display: block;
        }
        .wts-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3rem);
            color: var(--text); font-weight: 700; line-height: 1.1; letter-spacing: -0.02em;
        }
        .wts-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;
        }
        .wts-card {
            padding: 40px 36px;
            background: #fff; border: 1px solid var(--border);
            border-radius: 20px; transition: all 0.3s;
        }
        .wts-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(34,119,187,0.1);
            border-color: rgba(34,119,187,0.25);
        }
        .wtc-step {
            font-family: var(--font-head); font-size: 9px;
            color: var(--orange); letter-spacing: 0.14em; text-transform: uppercase;
            margin-bottom: 12px; display: block;
        }
        .wtc-title {
            font-family: var(--font-head); font-size: 1.15rem;
            color: var(--text); margin-bottom: 12px; line-height: 1.2;
        }
        .wtc-desc {
            font-size: 0.9rem; color: var(--text-muted); line-height: 1.7;
        }

        /* ── CTA ── */
        .svc-cta {
            padding: 120px 5%;
            background: var(--bg-dark);
            position: relative; overflow: hidden; text-align: center;
        }
        .svc-cta::before {
            content: ''; position: absolute; bottom: -30%; left: 50%; transform: translateX(-50%);
            width: 80%; height: 60vh;
            background: radial-gradient(ellipse at bottom, rgba(34,119,187,0.2) 0%, transparent 65%);
            filter: blur(60px); pointer-events: none;
        }
        .svc-cta-inner { max-width: 640px; margin: 0 auto; position: relative; z-index: 1; }
        .svc-cta-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 20px; display: block;
        }
        .svc-cta-title {
            font-family: var(--font-head); font-size: clamp(2.5rem, 5vw, 4rem);
            color: #fff; font-weight: 700; line-height: 1.0; letter-spacing: -0.03em;
            margin-bottom: 20px; text-transform: uppercase;
        }
        .svc-cta-desc {
            font-size: 1rem; color: rgba(255,255,255,0.55); line-height: 1.7; margin-bottom: 40px;
        }
        .svc-cta-btns { display: flex; gap: 14px; justify-content: center; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .comm-detail-header { flex-direction: column; align-items: flex-start; gap: 16px; }
            .cdh-desc { text-align: left; }
            .cap-inner { grid-template-columns: 1fr; gap: 50px; }
            .cap-left { position: static; }
            .wts-grid { grid-template-columns: 1fr 1fr; }
            .cfi-body { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .svc-hero-inner { padding: 110px 5% 56px; }
            .comm-detail-section { padding: 80px 5%; }
            .cap-section { padding: 80px 5%; }
            .why-trading-section { padding: 80px 5%; }
            .svc-cta { padding: 80px 5%; }
            .cap-grid { grid-template-columns: 1fr; }
            .wts-grid { grid-template-columns: 1fr; }
            .svc-cta-btns { flex-direction: column; align-items: center; }
            .cfi-header { grid-template-columns: 40px 1fr; }
            .cfi-badge { display: none; }
            .sh-title { font-size: clamp(3rem, 13vw, 5rem); }
        }
        @media (max-width: 600px) {
            .svc-hero-inner { padding: 96px 5% 44px; }
            .comm-detail-section { padding: 60px 5%; }
            .cap-section { padding: 60px 5%; }
            .why-trading-section { padding: 60px 5%; }
            .svc-cta { padding: 60px 5%; }
            .wts-card { padding: 28px 24px; }
            .cap-card { padding: 24px 20px; }
        }
    </style>

    {{-- HERO --}}
    <section class="svc-hero">
        <div class="svc-hero-bg" id="svcHeroBg"></div>
        <div class="svc-hero-inner">
            <span class="sh-eyebrow svc-anim">{{ _t($p['services_eyebrow']->title ?? '') }}</span>
            <h1 class="sh-title svc-anim">
                {{ _t($p['services_title_line1']->title ?? '') }}<br>
                <span class="t-blue">{{ _t($p['services_title_line2']->title ?? '') }}</span>
            </h1>
            <p class="sh-desc svc-anim">{{ _t($p['services_hero_desc']->title ?? '') }}</p>
        </div>
    </section>

    {{-- COMMODITY DETAIL ITEMS --}}
    <section class="comm-detail-section">
        <div class="comm-detail-inner">
            <div class="comm-detail-header">
                <div class="cdh-left">
                    <span class="cdh-tag svc-anim2">{{ _t($p['svc_comm_tag']->title ?? 'Our Commodities') }}</span>
                    <h2 class="cdh-title svc-anim2">{!! _t($p['svc_comm_title']->title ?? 'Six Core<br>Trading Areas') !!}</h2>
                </div>
                <p class="cdh-desc svc-anim2">
                    {{ _t($p['svc_comm_desc']->title ?? '') }}
                </p>
            </div>

            <div class="comm-items">

                @if(isset($svc_commodities) && $svc_commodities->isNotEmpty())
                    @foreach($svc_commodities as $comm)
                    <div class="comm-feat-item svc-ci-anim">
                        <div class="cfi-header">
                            <span class="cfi-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="cfi-title-wrap">
                                <span class="cfi-cat">{{ _t($comm->short_content) }}</span>
                                <div class="cfi-name">{!! _t($comm->title) !!}</div>
                            </div>
                        </div>
                        <div class="cfi-body">
                            <p class="cfi-desc">{!! _t($comm->content) !!}</p>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    {{-- CAPABILITIES --}}
    <section class="cap-section">
        <div class="cap-inner">

            <div class="cap-left">
                <div class="cap-left-tag">{{ _t($p['services_edge_tag']->title ?? 'Our Edge') }}</div>
                <h2 class="cap-left-title">
                    {!! _t($p['services_edge_title']->title ?? 'What Sets Us Apart') !!}
                </h2>
                <p class="cap-left-desc">
                    {{ _t($p['services_edge_desc']->title ?? '') }}
                </p>
                @if(isset($services_caps) && $services_caps->count() > 0)
                <!-- <div class="cap-left-stat">
                    <div class="cap-stat-num">{{ $services_caps->count() }}</div>
                    <div class="cap-stat-lbl">{{ _t($p['services_edge_tag']->title ?? 'Core capabilities') }}</div>
                </div> -->
                @endif
            </div>

            <div class="cap-grid">
                @if(isset($services_caps) && $services_caps->isNotEmpty())
                    @foreach($services_caps as $cap)
                    <div class="cap-card svc-cap-anim">
                        <div class="cap-card-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <!-- <div class="cap-card-icon">
                            <i class="feather icon-{{ _t($cap->options) }}" style="font-size: 1.2rem;"></i>
                        </div> -->
                        <div class="cap-card-title">{{ _t($cap->title) }}</div>
                        <p class="cap-card-desc">{!! _t($cap->short_content) !!}</p>
                    </div>
                    @endforeach
                @endif
            </div>

        </div>
    </section>

    {{-- PARALLAX BREAK --}}
    <div class="parallax-break">
        <div class="parallax-break-img" style="background-image:url('/assets/public/images/parallax-services.jpeg');" data-parallax></div>
        <div class="parallax-break-overlay"></div>
    </div>

    {{-- WHY CHOOSE PANASIA --}}
    <!-- <section class="why-trading-section">
        <div class="wts-inner">
            <div class="wts-header">
                <span class="wts-tag svc-anim3">{{ _t($p['services_how_tag']->title ?? '') }}</span>
                <h2 class="wts-title svc-anim3">{{ _t($p['services_how_title']->title ?? '') }}</h2>
            </div>
            <div class="wts-grid">
                @if(isset($services_process) && $services_process->isNotEmpty())
                    @foreach($services_process as $step)
                    <div class="wts-card svc-wts-anim">
                        @if($step->options)
                            <span class="wtc-step">{{ $step->options }}</span>
                        @endif
                        <h3 class="wtc-title">{{ _t($step->title) }}</h3>
                        <p class="wtc-desc">{!! _t($step->short_content) !!}</p>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section> -->

    {{-- CTA DARK --}}
    <section class="svc-cta">
        <div class="svc-cta-inner">
            <span class="svc-cta-tag">{{ _t($p['services_cta_tag']->title ?? 'Start Trading') }}</span>
            <h2 class="svc-cta-title">{{ _t($p['services_cta_title_line1']->title ?? 'Trade With') }}<br>{{ _t($p['services_cta_title_line2']->title ?? 'Confidence.') }}</h2>
            <p class="svc-cta-desc">{{ _t($p['services_cta_desc']->title ?? '') }}</p>
            <div class="svc-cta-btns">
                <a href="/contacts" class="btn-primary">
                    <span>{{ _t($p['services_cta_btn']->title ?? 'Contact Our Trading Desk') }}</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="/about" class="btn-secondary" style="border-color:rgba(255,255,255,0.2); color:rgba(255,255,255,0.7);">
                    {{ _t($p['services_about_btn']->title ?? 'About Panasia Group') }}
                </a>
            </div>
        </div>
    </section>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        /* Hero */
        gsap.fromTo(".svc-anim", { y: 40, opacity: 0 }, {
            y: 0, opacity: 1, duration: 1.1, stagger: 0.18,
            ease: "power3.out", delay: 0.3
        });

        /* Hero bg parallax */
        const svcHeroBg = document.getElementById('svcHeroBg');
        if (svcHeroBg) {
            gsap.to(svcHeroBg, {
                yPercent: 18, ease: 'none',
                scrollTrigger: { trigger: '.svc-hero', start: 'top top', end: 'bottom top', scrub: true }
            });
        }

        /* Parallax image breaks */
        document.querySelectorAll('[data-parallax]').forEach(el => {
            gsap.to(el, {
                yPercent: 22, ease: 'none',
                scrollTrigger: { trigger: el.closest('.parallax-break'), start: 'top bottom', end: 'bottom top', scrub: true }
            });
        });

        /* Section headers */
        ['svc-anim2', 'svc-anim3'].forEach(cls => {
            gsap.utils.toArray('.' + cls).forEach((el, i) => {
                gsap.set(el, { opacity: 0, y: 22 });
                ScrollTrigger.create({
                    trigger: el, start: "top 85%",
                    onEnter: () => gsap.to(el, {
                        opacity: 1, y: 0, duration: 0.9,
                        delay: i * 0.14, ease: "power3.out"
                    })
                });
            });
        });

        /* Commodity items stagger */
        gsap.utils.toArray('.svc-ci-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 20 });
            ScrollTrigger.create({
                trigger: el, start: "top 88%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.8,
                    delay: i * 0.07, ease: "power3.out"
                })
            });
        });

        /* Capability cards */
        gsap.utils.toArray('.svc-cap-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: el, start: "top 85%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.8,
                    delay: (i % 2) * 0.1, ease: "power3.out"
                })
            });
        });

        /* Why cards */
        gsap.utils.toArray('.svc-wts-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: el, start: "top 85%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.85,
                    delay: (i % 3) * 0.1, ease: "power3.out"
                })
            });
        });

        /* CTA */
        gsap.set('.svc-cta-inner', { opacity: 0, y: 30 });
        ScrollTrigger.create({
            trigger: '.svc-cta', start: "top 80%",
            onEnter: () => gsap.to('.svc-cta-inner', { opacity: 1, y: 0, duration: 1, ease: "power3.out" })
        });
    </script>

</x-public-layout>
