<x-public-layout>

<style>
    /* ── HERO ── */
    .ups-hero {
        min-height: 72vh; padding: 0;
        background: var(--bg-dark);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .ups-hero-bg {
        position: absolute; inset: 0;
        background: url('/assets/public/images/upstream-hero.jpg') center/cover no-repeat;
    }
    .ups-hero-bg::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(2,12,26,0.9) 0%, rgba(10,32,64,0.75) 50%, rgba(2,12,26,0.92) 100%);
    }
    .ups-hero::before {
        content: 'ASSETS';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 20vw; font-weight: 700;
        color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 2;
    }
    .ups-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 3;
        padding: 180px 5% 90px;
    }
    .ups-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        margin-bottom: 22px; display: block; text-transform: uppercase;
    }
    .ups-title {
        font-family: var(--font-head);
        font-size: clamp(3.2rem, 7.5vw, 7rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
    }
    .ups-title .t-blue { color: var(--blue); }
    .ups-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.8;
        max-width: 560px;
    }

    /* ── INTRO ── */
    .ups-intro {
        background: var(--bg); padding: 100px 5%;
    }
    .ups-intro-inner {
        max-width: var(--container); margin: 0 auto;
    }
    .ups-intro-quote {
        font-family: var(--font-head);
        font-size: clamp(1.5rem, 2.8vw, 2.4rem);
        font-weight: 700; line-height: 1.15;
        letter-spacing: -0.025em; color: var(--text);
        max-width: 820px; margin-bottom: 28px;
    }
    .ups-intro-quote span { color: var(--blue); }
    .ups-intro-body {
        font-size: 1rem; color: var(--text-muted); line-height: 1.85;
        max-width: 680px;
    }

    /* ── TWO SEGMENTS ── */
    .ups-segments {
        background: var(--bg-dark); padding: 110px 5%;
        position: relative; overflow: hidden;
    }
    .ups-segments::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse at 20% 60%, rgba(34,119,187,0.12) 0%, transparent 60%);
        pointer-events: none;
    }
    .ups-segments-inner { max-width: var(--container); margin: 0 auto; }
    .ups-seg-head { margin-bottom: 70px; }
    .ups-seg-head .section-title { color: #fff; }
    .ups-seg-head .section-tag   { color: var(--orange); }

    .ups-seg-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 2px;
    }
    .ups-seg {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.07);
        padding: 56px 44px; position: relative; overflow: hidden;
        transition: background 0.3s;
    }
    .ups-seg:hover { background: rgba(255,255,255,0.05); }
    .ups-seg::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    }
    .ups-seg:nth-child(1)::before { background: var(--blue); }
    .ups-seg:nth-child(2)::before { background: var(--orange); }
    .ups-seg-icon {
        width: 52px; height: 52px; border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 28px; color: var(--blue);
    }
    .ups-seg:nth-child(2) .ups-seg-icon { color: var(--orange); }
    .ups-seg-tag {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 14px; display: block;
    }
    .ups-seg:nth-child(2) .ups-seg-tag { color: rgba(255,124,16,0.7); }
    .ups-seg-title {
        font-family: var(--font-head); font-size: clamp(1.4rem, 2.5vw, 2rem);
        color: #fff; font-weight: 700; letter-spacing: -0.02em;
        line-height: 1.15; margin-bottom: 20px;
    }
    .ups-seg-desc {
        font-size: 0.95rem; color: rgba(255,255,255,0.5); line-height: 1.82;
    }
    .ups-seg-regions {
        margin-top: 32px; display: flex; flex-wrap: wrap; gap: 8px;
    }
    .ups-seg-region {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.12em; text-transform: uppercase;
        padding: 5px 12px; border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.4);
    }

    /* ── PARALLAX BREAK ── */
    .ups-parallax {
        height: 420px; position: relative; overflow: hidden;
    }
    .ups-parallax-img {
        position: absolute; top: -25%; left: 0; right: 0; bottom: -25%;
        background: url('/assets/public/images/upstream-field.jpg') center/cover no-repeat;
        will-change: transform;
    }
    .ups-parallax-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(2,12,26,0.5), rgba(2,12,26,0.6));
    }

    /* ── CTA ── */
    .ups-cta {
        background: var(--bg); padding: 100px 5%; text-align: center;
    }
    .ups-cta-inner { max-width: 560px; margin: 0 auto; }
    .ups-cta-tag {
        font-family: var(--font-head); font-size: 10px;
        color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
        margin-bottom: 20px; display: block;
    }
    .ups-cta-title {
        font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.5rem);
        color: var(--text); font-weight: 700; line-height: 1.05;
        letter-spacing: -0.025em; margin-bottom: 16px; text-transform: uppercase;
    }
    .ups-cta-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 36px; }
    .ups-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    @media (max-width: 768px) {
        .ups-seg-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .ups-title { font-size: clamp(3rem, 12vw, 5rem) !important; }
    }
</style>


{{-- HERO --}}
<section class="ups-hero">
    <div class="ups-hero-bg" id="upsHeroBg"></div>
    <div class="ups-hero-inner">
        <span class="ups-eyebrow ups-anim">{{ _t($p['ups_hero_eyebrow']->title ?? 'Energy Assets') }}</span>
        <h1 class="ups-title ups-anim">
            {{ _t($p['ups_hero_title1']->title ?? 'Upstream') }} &amp;<br><span class="t-blue">{{ _t($p['ups_hero_title2']->title ?? 'Downstream') }}</span><br>{{ _t($p['ups_hero_title3']->title ?? 'Assets.') }}
        </h1>
        <p class="ups-hero-desc ups-anim">
            {{ _t($p['ups_hero_desc']->title ?? '') }}
        </p>
    </div>
</section>


{{-- INTRO --}}
<section class="ups-intro">
    <div class="ups-intro-inner">
        <p class="ups-intro-quote ups-anim2">
            {!! _t($p['ups_intro_quote']->title ?? '') !!}
        </p>
        <p class="ups-intro-body ups-anim2">
            {{ _t($p['ups_intro_body']->title ?? '') }}
        </p>
    </div>
</section>


{{-- TWO SEGMENTS --}}
<section class="ups-segments">
    <div class="ups-segments-inner">
        <div class="ups-seg-head">
            <span class="section-tag ups-head-anim">{{ _t($p['ups_seg_tag']->title ?? 'Our Focus Areas') }}</span>
            <h2 class="section-title ups-head-anim" style="color:#fff;">{!! _t($p['ups_seg_title']->title ?? 'Two Integrated<br>Business Segments') !!}</h2>
        </div>
        <div class="ups-seg-grid">
            @if(isset($ups_segments) && $ups_segments->isNotEmpty())
                @foreach($ups_segments as $seg)
                <div class="ups-seg ups-seg-anim">
                    <span class="ups-seg-tag">{{ _t($seg->short_content) }}</span>
                    <h3 class="ups-seg-title">{!! nl2br(e(_t($seg->title))) !!}</h3>
                    <p class="ups-seg-desc">{!! _t($seg->content) !!}</p>
                    @if(!empty($seg->options))
                    <div class="ups-seg-regions">
                        @foreach(array_map('trim', explode(',', $seg->options)) as $region)
                            <span class="ups-seg-region">{{ $region }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- PARALLAX BREAK --}}
<div class="ups-parallax">
    <div class="ups-parallax-img" data-parallax></div>
    <div class="ups-parallax-overlay"></div>
</div>


{{-- CTA --}}
<section class="ups-cta">
    <div class="ups-cta-inner">
        <span class="ups-cta-tag">{{ _t($p['ups_cta_tag']->title ?? 'Learn More') }}</span>
        <h2 class="ups-cta-title">{!! _t($p['ups_cta_title']->title ?? 'Explore Our<br>Projects.') !!}</h2>
        <p class="ups-cta-desc">
            {{ _t($p['ups_cta_desc']->title ?? '') }}
        </p>
        <div class="ups-cta-btns">
            <a href="/refinery" class="btn-primary">
                <span>{{ _t($p['btn_refinery_storage']->title ?? 'Refinery & Storage') }}</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
           
        </div>
    </div>
</section>


<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo('.ups-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
    });

    const upsHeroBg = document.getElementById('upsHeroBg');
    if (upsHeroBg) {
        gsap.to(upsHeroBg, {
            yPercent: 18, ease: 'none',
            scrollTrigger: { trigger: '.ups-hero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    gsap.utils.toArray('.ups-anim2').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 28 }, {
            opacity: 1, y: 0, duration: 0.9, delay: i * 0.14, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    gsap.utils.toArray('.ups-head-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.ups-seg-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 40 }, {
            opacity: 1, y: 0, duration: 0.9, delay: i * 0.15, ease: 'power3.out',
            scrollTrigger: { trigger: '.ups-seg-grid', start: 'top 82%' }
        });
    });

    document.querySelectorAll('[data-parallax]').forEach(el => {
        gsap.to(el, {
            yPercent: 22, ease: 'none',
            scrollTrigger: { trigger: el.closest('.ups-parallax'), start: 'top bottom', end: 'bottom top', scrub: true }
        });
    });
</script>

</x-public-layout>
