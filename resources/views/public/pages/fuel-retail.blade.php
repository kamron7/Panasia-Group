<x-public-layout>

<style>
    /* ── HERO ── */
    .fr-hero {
        min-height: 72vh; padding: 0;
        background: var(--bg-dark);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .fr-hero-bg {
        position: absolute; inset: 0;
        background: url('/assets/public/images/fuel-retail-hero.jpg') center/cover no-repeat;
    }
    .fr-hero-bg::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(2,12,26,0.9) 0%, rgba(10,32,64,0.78) 50%, rgba(2,12,26,0.93) 100%);
    }
    .fr-hero::before {
        content: 'RETAIL';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 22vw; font-weight: 700;
        color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 2;
    }
    .fr-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 3;
        padding: 180px 5% 90px;
    }
    .fr-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        margin-bottom: 22px; display: block; text-transform: uppercase;
    }
    .fr-title {
        font-family: var(--font-head);
        font-size: clamp(3rem, 7vw, 6.5rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
    }
    .fr-title .t-blue { color: var(--blue); }
    .fr-title .t-orange { color: var(--orange); }
    .fr-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.8;
        max-width: 560px;
    }

    /* ── INTRO ── */
    .fr-intro { background: var(--bg); padding: 100px 5%; }
    .fr-intro-inner {
        max-width: var(--container); margin: 0 auto;
        display: grid; grid-template-columns: 1fr 360px; gap: 80px; align-items: start;
    }
    .fr-intro-quote {
        font-family: var(--font-head);
        font-size: clamp(1.5rem, 2.8vw, 2.3rem);
        font-weight: 700; line-height: 1.15;
        letter-spacing: -0.025em; color: var(--text); margin-bottom: 24px;
    }
    .fr-intro-quote span { color: var(--orange); }
    .fr-intro-body { font-size: 1rem; color: var(--text-muted); line-height: 1.85; }
    .fr-stat-stack { display: flex; flex-direction: column; gap: 16px; }
    .fr-stat-card {
        border: 1px solid var(--border); border-radius: 14px;
        padding: 28px 24px;
    }
    .fsc-num {
        font-family: var(--font-head); font-size: 2.8rem;
        font-weight: 700; color: var(--text); letter-spacing: -0.04em;
        line-height: 1; margin-bottom: 6px;
    }
    .fsc-num span { color: var(--orange); }
    .fsc-lbl { font-size: 0.8rem; color: var(--text-muted); }

    /* ── EXPANSION PLAN ── */
    .fr-plan { background: var(--bg-dark); padding: 110px 5%; }
    .fr-plan-inner { max-width: var(--container); margin: 0 auto; }
    .fr-plan-head { margin-bottom: 70px; }
    .fr-plan-head .section-title { color: #fff; }
    .fr-plan-head .section-tag   { color: var(--orange); }

    .fr-plan-steps {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;
        position: relative;
    }
    .fr-step {
        padding: 52px 40px;
        /* TODO: replace natural-gas.jpg with the actual PANASIA station photo */
        background:
            linear-gradient(rgba(2,12,26,0.87), rgba(2,12,26,0.87)),
            url('/assets/public/images/parallax-ops.jpg') center/cover no-repeat;
        border: 1px solid rgba(255,255,255,0.06);
        position: relative; overflow: hidden;
        transition: background 0.3s;
    }
    .fr-step:hover {
        background:
            linear-gradient(rgba(2,12,26,0.72), rgba(2,12,26,0.72)),
            url('/assets/public/images/parallax-ops.jpg') center/cover no-repeat;
    }
    .fr-step::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--blue), var(--orange));
        transform: scaleX(0); transform-origin: left; transition: transform 0.4s;
    }
    .fr-step:hover::before { transform: scaleX(1); }
    .fs-step-num {
        font-family: var(--font-head); font-size: 5rem; font-weight: 700;
        color: rgba(255,255,255,0.04); letter-spacing: -0.05em;
        line-height: 1; margin-bottom: 24px;
    }
    .fs-tag {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 12px; display: block;
    }
    .fs-title {
        font-family: var(--font-head); font-size: 1.2rem;
        color: #fff; font-weight: 700; margin-bottom: 14px;
        line-height: 1.2; letter-spacing: -0.01em;
    }
    .fs-desc { font-size: 0.9rem; color: rgba(255,255,255,0.45); line-height: 1.72; }

    /* ── PRODUCTS OFFERED ── */
    .fr-products { background: var(--bg-alt); padding: 100px 5%; }
    .fr-products-inner { max-width: var(--container); margin: 0 auto; }
    .fr-products-head { margin-bottom: 56px; }
    .fr-prod-list {
        display: flex; flex-wrap: wrap; gap: 10px;
    }
    .fr-prod-item {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 20px; border-radius: 50px;
        border: 1px solid var(--border); background: var(--bg);
        transition: all 0.3s;
    }
    .fr-prod-item:hover {
        border-color: rgba(34,119,187,0.4);
        box-shadow: 0 4px 20px rgba(34,119,187,0.08);
    }
    .fr-prod-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--orange); flex-shrink: 0;
    }
    .fr-prod-item:nth-child(even) .fr-prod-dot { background: var(--blue); }
    .fr-prod-name {
        font-family: var(--font-head); font-size: 0.82rem;
        font-weight: 700; color: var(--text); letter-spacing: 0.02em;
    }

    /* ── CTA ── */
    .fr-cta {
        background: var(--bg); padding: 100px 5%; text-align: center;
    }
    .fr-cta-inner { max-width: 560px; margin: 0 auto; }
    .fr-cta-tag {
        font-family: var(--font-head); font-size: 10px;
        color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
        margin-bottom: 20px; display: block;
    }
    .fr-cta-title {
        font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.5rem);
        color: var(--text); font-weight: 700; line-height: 1.05;
        letter-spacing: -0.025em; margin-bottom: 16px; text-transform: uppercase;
    }
    .fr-cta-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 36px; }
    .fr-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    @media (max-width: 1024px) {
        .fr-intro-inner { grid-template-columns: 1fr; }
        .fr-plan-steps { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .fr-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
    }
</style>


{{-- HERO --}}
<section class="fr-hero">
    <div class="fr-hero-bg" id="frHeroBg"></div>
    <div class="fr-hero-inner">
        <span class="fr-eyebrow fr-anim">{{ _t($p['fr_hero_eyebrow']->title ?? 'Downstream Retail') }}</span>
        <h1 class="fr-title fr-anim">
            {{ _t($p['fr_hero_title1']->title ?? 'Fuel Retail') }}<br><span class="t-orange">{{ _t($p['fr_hero_title2']->title ?? 'Network.') }}</span>
        </h1>
        <p class="fr-hero-desc fr-anim">
            {{ _t($p['fr_hero_desc']->title ?? '') }}
        </p>
    </div>
</section>


{{-- INTRO --}}
<section class="fr-intro">
    <div class="fr-intro-inner">
        <div>
            <p class="fr-intro-quote fr-anim2">
                {!! _t($p['fr_intro_quote']->title ?? '') !!}
            </p>
            <p class="fr-intro-body fr-anim2">
                {{ _t($p['fr_intro_body']->title ?? '') }}
            </p>
        </div>
        <div class="fr-stat-stack">
            <div class="fr-stat-card fr-anim2">
                <div class="fsc-num">{{ _t($p['fr_stat1_num']->title ?? '200+') }}</div>
                <div class="fsc-lbl">{{ _t($p['fr_stat1_lbl']->title ?? 'Planned stations across Central Asia') }}</div>
            </div>
            <div class="fr-stat-card fr-anim2">
                <div class="fsc-num" style="font-size:1.8rem;color:var(--blue);">{{ _t($p['fr_stat2_val']->title ?? 'Central Asia') }}</div>
                <div class="fsc-lbl">{{ _t($p['fr_stat2_lbl']->title ?? '') }}</div>
            </div>
        </div>
    </div>
</section>


{{-- EXPANSION PLAN --}}
<section class="fr-plan">
    <div class="fr-plan-inner">
        <div class="fr-plan-head">
            <span class="section-tag fr-head-anim">{{ _t($p['fr_plan_tag']->title ?? 'Growth Strategy') }}</span>
            <h2 class="section-title fr-head-anim" style="color:#fff;">{{ _t($p['fr_plan_title']->title ?? 'Expansion Roadmap') }}</h2>
        </div>
        <div class="fr-plan-steps">
            @if(isset($fr_steps) && $fr_steps->isNotEmpty())
                @foreach($fr_steps as $step)
                <div class="fr-step fr-step-anim">
                    <div class="fs-step-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <span class="fs-tag">{{ _t($step->short_content) }}</span>
                    <h3 class="fs-title">{!! nl2br(e(_t($step->title))) !!}</h3>
                    <p class="fs-desc">{!! _t($step->content) !!}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- PRODUCTS OFFERED --}}



{{-- CTA --}}
<section class="fr-cta">
    <div class="fr-cta-inner">
        <span class="fr-cta-tag">{{ _t($p['fr_cta_tag']->title ?? 'Investment Opportunity') }}</span>
        <h2 class="fr-cta-title">{!! _t($p['fr_cta_title']->title ?? 'Join Our<br>Expansion.') !!}</h2>
        <p class="fr-cta-desc">
            {{ _t($p['fr_cta_desc']->title ?? '') }}
        </p>
        <div class="fr-cta-btns">
            <a href="/contacts" class="btn-primary">
                <span>{{ _t($p['btn_get_in_touch']->title ?? 'Get in Touch') }}</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            
        </div>
    </div>
</section>


<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo('.fr-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
    });

    const frHeroBg = document.getElementById('frHeroBg');
    if (frHeroBg) {
        gsap.to(frHeroBg, {
            yPercent: 18, ease: 'none',
            scrollTrigger: { trigger: '.fr-hero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    gsap.utils.toArray('.fr-anim2').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 28 }, {
            opacity: 1, y: 0, duration: 0.9, delay: i * 0.12, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    gsap.utils.toArray('.fr-head-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.fr-step-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 36 }, {
            opacity: 1, y: 0, duration: 0.85, delay: i * 0.14, ease: 'power3.out',
            scrollTrigger: { trigger: '.fr-plan-steps', start: 'top 82%' }
        });
    });

    gsap.utils.toArray('.fr-prod-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, scale: 0.92 }, {
            opacity: 1, scale: 1, duration: 0.5, delay: i * 0.06, ease: 'back.out(1.4)',
            scrollTrigger: { trigger: '.fr-prod-list', start: 'top 88%' }
        });
    });
</script>

</x-public-layout>
