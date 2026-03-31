<x-public-layout>

    <style>
        .ptr-hero {
            min-height: 60vh; padding: 0;
            background: var(--bg-dark);
            position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
        }
        .ptr-hero::before {
            content: 'PARTNERS';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-family: var(--font-head); font-size: 20vw; font-weight: 700;
            color: rgba(255,255,255,0.025); white-space: nowrap; pointer-events: none;
            letter-spacing: -0.01em; z-index: 0;
        }
        .ptr-hero-inner {
            max-width: var(--container); margin: 0 auto;
            position: relative; z-index: 1;
            padding: 160px 5% 80px;
        }
        .ptr-eyebrow {
            font-family: var(--font-head); font-size: 10px;
            letter-spacing: 0.18em; color: var(--orange);
            margin-bottom: 20px; display: block; text-transform: uppercase;
        }
        .ptr-title {
            font-family: var(--font-head);
            font-size: clamp(3rem, 7vw, 7rem);
            line-height: 0.95; color: #fff; letter-spacing: -0.02em;
            font-weight: 700; text-transform: uppercase; margin-bottom: 28px;
        }
        .ptr-title span { color: var(--blue); }
        .ptr-desc {
            font-size: 1.05rem; color: rgba(255,255,255,0.6);
            line-height: 1.8; max-width: 560px;
        }

        /* ── PARTNERS GRID ── */
        .ptr-section {
            padding: 100px 5%;
            background: var(--bg);
        }
        .ptr-inner { max-width: var(--container); margin: 0 auto; }
        .ptr-header { margin-bottom: 64px; }
        .ptr-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 14px; display: block;
        }
        .ptr-h2 {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3rem);
            color: var(--text); font-weight: 700; line-height: 1.1;
        }

        .ptr-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px;
            background: var(--border);
            border: 1px solid var(--border); border-radius: 18px; overflow: hidden;
        }
        .ptr-card {
            display: flex; flex-direction: column;
            transition: background 0.3s;
            background: var(--bg);
        }
        .ptr-card:hover { background: var(--bg-alt); }

        /* ── Logo area — full width, fixed height, handles all aspect ratios ── */
        .ptr-card-logo {
            width: 100%; height: 130px;
            display: flex; align-items: center; justify-content: center;
            padding: 24px 28px;
            border-bottom: 1px solid var(--border);
            background: #fff;
            transition: background 0.3s;
            overflow: hidden;
        }
        .ptr-card:hover .ptr-card-logo { background: #f5f7fa; }
        /* Real logo image — contain so any shape fits */
        .ptr-card-logo img {
            max-width: 100%; max-height: 100%;
            width: auto; height: auto;
            object-fit: contain; display: block;
        }
        /* Abbreviation fallback */
        .ptr-card-logo-abbr {
            font-family: var(--font-head); font-size: 1.8rem; font-weight: 700;
            color: var(--blue); letter-spacing: -0.02em; line-height: 1;
        }

        /* ── Card text body ── */
        .ptr-card-body { padding: 22px 24px; flex: 1; }
        .ptr-card-country {
            font-family: var(--font-head); font-size: 9px;
            color: var(--orange); letter-spacing: 0.14em; text-transform: uppercase;
            margin-bottom: 5px; display: block;
        }
        .ptr-card-name {
            font-family: var(--font-head); font-size: 1rem;
            color: var(--text); font-weight: 700; margin-bottom: 8px; line-height: 1.2;
        }
        .ptr-card-desc {
            font-size: 0.82rem; color: var(--text-muted); line-height: 1.65;
        }

        /* Static fallback grid (no DB data yet) */
        .ptr-static-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
        }
        .ptr-logo-card {
            border: 1px solid var(--border); border-radius: 12px;
            padding: 28px 20px;
            display: flex; flex-direction: column; align-items: center; gap: 12px;
            transition: all 0.3s; background: var(--bg);
        }
        .ptr-logo-card:hover {
            border-color: rgba(34,119,187,0.3);
            box-shadow: 0 8px 28px rgba(34,119,187,0.07);
        }
        .plc-abbr {
            font-family: var(--font-head); font-size: 1.5rem; font-weight: 700;
            color: var(--blue);
        }
        .plc-name {
            font-family: var(--font-head); font-size: 0.75rem; font-weight: 600;
            color: var(--text); text-align: center; line-height: 1.3;
        }
        .plc-region {
            font-size: 0.72rem; color: var(--text-muted); text-align: center;
        }

        /* ── CTA ── */
        .ptr-cta {
            padding: 100px 5%; background: var(--bg-dark); text-align: center;
            position: relative; overflow: hidden;
        }
        .ptr-cta::before {
            content: ''; position: absolute; bottom: -20%; left: 50%; transform: translateX(-50%);
            width: 70%; height: 50vh;
            background: radial-gradient(ellipse at bottom, rgba(34,119,187,0.18) 0%, transparent 65%);
            filter: blur(60px); pointer-events: none;
        }
        .ptr-cta-inner { max-width: 580px; margin: 0 auto; position: relative; z-index: 1; }
        .ptr-cta-tag {
            font-family: var(--font-head); font-size: 10px;
            color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
            margin-bottom: 20px; display: block;
        }
        .ptr-cta-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.5rem);
            color: #fff; font-weight: 700; line-height: 1.0; letter-spacing: -0.02em;
            margin-bottom: 18px; text-transform: uppercase;
        }
        .ptr-cta-desc {
            font-size: 1rem; color: rgba(255,255,255,0.55); line-height: 1.7; margin-bottom: 36px;
        }
        .ptr-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        @media (max-width: 1200px) {
            .ptr-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 900px) {
            .ptr-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .ptr-hero-inner { padding: 110px 5% 56px; }
            .ptr-section { padding: 70px 5%; }
            .ptr-cta { padding: 70px 5%; }
            .ptr-cta-btns { flex-direction: column; align-items: center; }
        }
        @media (max-width: 480px) {
            .ptr-grid { grid-template-columns: 1fr 1fr; }
            .ptr-card-logo { height: 100px; padding: 16px; }
        }
        @media (max-width: 600px) {
            .ptr-hero-inner { padding: 96px 5% 44px; }
            .ptr-section { padding: 56px 5%; }
            .ptr-cta { padding: 56px 5%; }
            .ptr-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
            .ptr-card { padding: 28px 24px; }
        }
    </style>

    {{-- HERO --}}
    <section class="ptr-hero">
        <div class="ptr-hero-inner">
            <span class="ptr-eyebrow ptr-anim">{{ _t($p['ptr_hero_eyebrow']->title ?? 'Strategic Partnerships') }}</span>
            <h1 class="ptr-title ptr-anim">
                {{ _t($p['ptr_hero_title1']->title ?? 'Our') }}<br><span>{{ _t($p['ptr_hero_title2']->title ?? 'Partners') }}</span>
            </h1>
            <p class="ptr-desc ptr-anim">
                {{ _t($p['ptr_hero_desc']->title ?? '') }}
            </p>
        </div>
    </section>

    {{-- PARTNERS SECTION --}}
    <section class="ptr-section">
        <div class="ptr-inner">
            <div class="ptr-header">
                <span class="ptr-tag ptr-anim2">{{ _t($p['ptr_section_tag']->title ?? 'Trusted Counterparties') }}</span>
                <h2 class="ptr-h2 ptr-anim2">{{ _t($p['ptr_section_title']->title ?? 'Strategic Partnership Network') }}</h2>
            </div>

            @if(isset($partners) && $partners->count())
                <div class="ptr-grid">
                    @foreach($partners as $partner)
                        <div class="ptr-card ptr-card-anim">
                            <div class="ptr-card-logo">
                                @if(!empty($partner->files))
                                    <img src="{{ url_u() . 'partners/' . getImgMain($partner) }}" alt="{{ _t($partner->title) }}">
                                @else
                                    <span class="ptr-card-logo-abbr">{{ strtoupper($partner->options2 ?: substr(_t($partner->title), 0, 4)) }}</span>
                                @endif
                            </div>
                            <div class="ptr-card-body">
                                @if(!empty($partner->options))
                                    <span class="ptr-card-country">{{ $partner->options }}</span>
                                @endif
                                <h3 class="ptr-card-name">{{ $partner->options2 }}</h3>
                                @if(!empty(_t($partner->short_content)))
                                    <p class="ptr-card-desc">{!! _t($partner->short_content) !!}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="ptr-cta">
        <div class="ptr-cta-inner">
            <span class="ptr-cta-tag">{{ _t($p['ptr_cta_tag']->title ?? 'Join Our Network') }}</span>
            <h2 class="ptr-cta-title">{!! _t($p['ptr_cta_title']->title ?? 'Become a<br>Partner.') !!}</h2>
            <p class="ptr-cta-desc">
                {{ _t($p['ptr_cta_desc']->title ?? '') }}
            </p>
            <div class="ptr-cta-btns">
                <a href="/contacts" class="btn-primary">
                    <span>{{ _t($p['btn_get_in_touch']->title ?? 'Get in Touch') }}</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="/about" class="btn-secondary" style="border-color:rgba(255,255,255,0.2); color:rgba(255,255,255,0.7);">
                    {{ _t($p['ptr_cta_btn_about']->title ?? 'About Panasia Group') }}
                </a>
            </div>
        </div>
    </section>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        gsap.fromTo('.ptr-anim', { y: 36, opacity: 0 }, {
            y: 0, opacity: 1, duration: 1.1, stagger: 0.16, ease: 'power3.out', delay: 0.3
        });

        gsap.utils.toArray('.ptr-anim2').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 20 });
            ScrollTrigger.create({
                trigger: el, start: 'top 85%',
                onEnter: () => gsap.to(el, { opacity: 1, y: 0, duration: 0.9, delay: i * 0.12, ease: 'power3.out' })
            });
        });

        gsap.utils.toArray('.ptr-card-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 20 });
            ScrollTrigger.create({
                trigger: el, start: 'top 88%',
                onEnter: () => gsap.to(el, { opacity: 1, y: 0, duration: 0.75, delay: (i % 3) * 0.08, ease: 'power3.out' })
            });
        });
    </script>

</x-public-layout>
