<x-public-layout>

<style>
    /* ── HERO ── */
    .ref-hero {
        min-height: 72vh; padding: 0;
        background: var(--bg-dark);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .ref-hero-bg {
        position: absolute; inset: 0;
        background: url('/assets/public/images/refinery-hero.jpg') center/cover no-repeat;
    }
    .ref-hero-bg::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(2,12,26,0.9) 0%, rgba(10,32,64,0.8) 50%, rgba(2,12,26,0.94) 100%);
    }
    .ref-hero::before {
        content: 'REFINERY';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 14vw; font-weight: 700;
        color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 2;
    }
    .ref-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 3;
        padding: 180px 5% 90px;
    }
    .ref-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        margin-bottom: 22px; display: block; text-transform: uppercase;
    }
    .ref-title {
        font-family: var(--font-head);
        font-size: clamp(3rem, 7vw, 6.5rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
    }
    .ref-title .t-blue { color: var(--blue); }
    .ref-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.8;
        max-width: 560px;
    }

    /* ── INTRO ── */
    .ref-intro { background: var(--bg); padding: 100px 5%; }
    .ref-intro-inner {
        max-width: var(--container); margin: 0 auto;
        display: grid; grid-template-columns: 1fr 380px; gap: 80px; align-items: start;
    }
    .ref-intro-quote {
        font-family: var(--font-head);
        font-size: clamp(1.5rem, 2.8vw, 2.3rem);
        font-weight: 700; line-height: 1.15;
        letter-spacing: -0.025em; color: var(--text); margin-bottom: 24px;
    }
    .ref-intro-quote span { color: var(--blue); }
    .ref-intro-body { font-size: 1rem; color: var(--text-muted); line-height: 1.85; }

    .ref-location-box {
        border: 1px solid var(--border); border-radius: 16px;
        padding: 36px 30px; background: var(--bg-alt);
    }
    .rlb-label {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.2em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 16px; display: block;
    }
    .rlb-name {
        font-family: var(--font-head); font-size: 1.3rem;
        font-weight: 700; color: var(--text); letter-spacing: -0.01em;
        line-height: 1.2; margin-bottom: 8px;
    }
    .rlb-loc {
        font-size: 0.875rem; color: var(--text-muted); margin-bottom: 24px;
    }
    .rlb-stat {
        padding: 16px 0; border-top: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
    }
    .rlb-stat-label { font-size: 0.8rem; color: var(--text-muted); }
    .rlb-stat-val {
        font-family: var(--font-head); font-size: 1.1rem;
        font-weight: 700; color: var(--text); letter-spacing: -0.02em;
    }

    /* ── PRODUCTS ── */
    .ref-products { background: var(--bg-dark); padding: 110px 5%; }
    .ref-products-inner { max-width: var(--container); margin: 0 auto; }
    .ref-products-head { margin-bottom: 64px; }
    .ref-products-head .section-title { color: #fff; }
    .ref-products-head .section-tag   { color: var(--orange); }

    .ref-prod-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;
    }
    .ref-prod-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.07);
        padding: 36px 28px; transition: background 0.3s;
    }
    .ref-prod-card:hover { background: rgba(255,255,255,0.06); }
    .rpc-icon {
        width: 44px; height: 44px; border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px; color: var(--blue);
    }
    .rpc-name {
        font-family: var(--font-head); font-size: 1rem;
        color: #fff; font-weight: 700; margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .rpc-desc { font-size: 0.875rem; color: rgba(255,255,255,0.45); line-height: 1.65; }

    /* ── EXPANSION ── */
    .ref-expansion { background: var(--bg); padding: 100px 5%; }
    .ref-expansion-inner {
        max-width: var(--container); margin: 0 auto;
        display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;
    }
    .ref-exp-tag {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.2em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 20px; display: block;
    }
    .ref-exp-title {
        font-family: var(--font-head); font-size: clamp(1.8rem, 3vw, 2.8rem);
        font-weight: 700; color: var(--text); letter-spacing: -0.03em;
        line-height: 1.1; margin-bottom: 20px;
    }
    .ref-exp-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.82; }
    .ref-exp-stat-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
    }
    .ref-exp-stat {
        border: 1px solid var(--border); border-radius: 14px;
        padding: 28px 24px;
    }
    .res-num {
        font-family: var(--font-head); font-size: 2.2rem;
        font-weight: 700; color: var(--text); letter-spacing: -0.04em;
        line-height: 1; margin-bottom: 6px;
    }
    .res-num span { color: var(--orange); }
    .res-lbl { font-size: 0.78rem; color: var(--text-muted); }

    /* ── CTA ── */
    .ref-cta {
        background: var(--bg-dark); padding: 100px 5%; text-align: center;
        position: relative; overflow: hidden;
    }
    .ref-cta::before {
        content: ''; position: absolute; bottom: -10%; left: 50%; transform: translateX(-50%);
        width: 60%; height: 40vh;
        background: radial-gradient(ellipse at bottom, rgba(34,119,187,0.15) 0%, transparent 65%);
        filter: blur(60px); pointer-events: none;
    }
    .ref-cta-inner { max-width: 560px; margin: 0 auto; position: relative; z-index: 1; }
    .ref-cta-tag {
        font-family: var(--font-head); font-size: 10px;
        color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
        margin-bottom: 20px; display: block;
    }
    .ref-cta-title {
        font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.5rem);
        color: #fff; font-weight: 700; line-height: 1.05;
        letter-spacing: -0.025em; margin-bottom: 16px; text-transform: uppercase;
    }
    .ref-cta-desc { font-size: 1rem; color: rgba(255,255,255,0.5); line-height: 1.7; margin-bottom: 36px; }
    .ref-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    @media (max-width: 1024px) {
        .ref-intro-inner { grid-template-columns: 1fr; }
        .ref-expansion-inner { grid-template-columns: 1fr; }
        .ref-prod-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 640px) {
        .ref-prod-grid { grid-template-columns: 1fr; }
        .ref-exp-stat-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .ref-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
    }
</style>


{{-- HERO --}}
<section class="ref-hero">
    <div class="ref-hero-bg" id="refHeroBg"></div>
    <div class="ref-hero-inner">
        <span class="ref-eyebrow ref-anim">{{ _t($p['ref_hero_eyebrow']->title ?? 'Processing Infrastructure') }}</span>
        <h1 class="ref-title ref-anim">
            {{ _t($p['ref_hero_title1']->title ?? 'Refinery') }} &amp;<br><span class="t-blue">{{ _t($p['ref_hero_title2']->title ?? 'Storage.') }}</span>
        </h1>
        <p class="ref-hero-desc ref-anim">
            {{ _t($p['ref_hero_desc']->title ?? '') }}
        </p>
    </div>
</section>


{{-- INTRO --}}
<section class="ref-intro">
    <div class="ref-intro-inner">
        <div>
            <p class="ref-intro-quote ref-anim2">
                {!! _t($p['ref_intro_quote']->title ?? '') !!}
            </p>
            <p class="ref-intro-body ref-anim2">
                {{ _t($p['ref_intro_body']->title ?? '') }}
            </p>
        </div>
        <div class="ref-location-box ref-anim2">
            <span class="rlb-label">{{ _t($p['ref_loc_label']->title ?? 'Facility Location') }}</span>
            <div class="rlb-name">{{ _t($p['ref_loc_name']->title ?? 'Chinaz Refinery') }}</div>
            <div class="rlb-loc">{{ _t($p['ref_loc_city']->title ?? '') }}</div>
            <div class="rlb-stat">
                <span class="rlb-stat-label">{{ _t($p['ref_loc_cap_label']->title ?? 'Storage Capacity') }}</span>
                <span class="rlb-stat-val">{{ _t($p['ref_loc_cap_val']->title ?? '~20,000 t') }}</span>
            </div>
            <div class="rlb-stat">
                <span class="rlb-stat-label">{{ _t($p['ref_loc_prod_label']->title ?? 'Products') }}</span>
                <span class="rlb-stat-val">{{ _t($p['ref_loc_prod_val']->title ?? '') }}</span>
            </div>
            <div class="rlb-stat" style="border-bottom:none;">
                <span class="rlb-stat-label">{{ _t($p['ref_loc_status_label']->title ?? 'Status') }}</span>
                <span class="rlb-stat-val" style="color:var(--orange);">{{ _t($p['ref_loc_status_val']->title ?? 'Operational') }}</span>
            </div>
        </div>
    </div>
</section>


{{-- PRODUCTS --}}
<section class="ref-products">
    <div class="ref-products-inner">
        <div class="ref-products-head">
            <span class="section-tag ref-head-anim">{{ _t($p['ref_prod_tag']->title ?? 'Output') }}</span>
            <h2 class="section-title ref-head-anim" style="color:#fff;">{{ _t($p['ref_prod_title']->title ?? 'Refined Products') }}</h2>
        </div>
        <div class="ref-prod-grid">
            @if(isset($ref_products) && $ref_products->isNotEmpty())
                @foreach($ref_products as $prod)
                <div class="ref-prod-card ref-prod-anim">
                    <div class="rpc-name">{{ _t($prod->title) }}</div>
                    <p class="rpc-desc">{!! _t($prod->content) !!}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- EXPANSION --}}
<section class="ref-expansion">
    <div class="ref-expansion-inner">
        <div>
            <span class="ref-exp-tag ref-anim2">{{ _t($p['ref_exp_tag']->title ?? 'Growth Plans') }}</span>
            <h2 class="ref-exp-title ref-anim2">{!! _t($p['ref_exp_title']->title ?? 'Expanding Refining<br>& Storage Capacity') !!}</h2>
            <p class="ref-exp-desc ref-anim2">
                {{ _t($p['ref_exp_desc']->title ?? '') }}
            </p>
        </div>
        <div class="ref-exp-stat-grid">
            <div class="ref-exp-stat ref-anim2">
                <div class="res-num">{{ _t($p['ref_exp_stat1_num']->title ?? '20K') }}</div>
                <div class="res-lbl">{{ _t($p['ref_exp_stat1_lbl']->title ?? 'Tonnes storage capacity') }}</div>
            </div>
            <div class="ref-exp-stat ref-anim2">
                <div class="res-num">{{ _t($p['ref_exp_stat2_num']->title ?? '3+') }}</div>
                <div class="res-lbl">{{ _t($p['ref_exp_stat2_lbl']->title ?? 'Product types produced') }}</div>
            </div>
            <div class="ref-exp-stat ref-anim2">
                <div class="res-num">{{ _t($p['ref_exp_stat3_num']->title ?? 'UZB') }}</div>
                <div class="res-lbl">{{ _t($p['ref_exp_stat3_lbl']->title ?? 'Uzbekistan — operational base') }}</div>
            </div>
            <div class="ref-exp-stat ref-anim2">
                <div class="res-num">{{ _t($p['ref_exp_stat4_num']->title ?? '200+') }}</div>
                <div class="res-lbl">{{ _t($p['ref_exp_stat4_lbl']->title ?? 'Planned fuel stations') }}</div>
            </div>
        </div>
    </div>
</section>


{{-- CTA --}}
<section class="ref-cta">
    <div class="ref-cta-inner">
        <span class="ref-cta-tag">{{ _t($p['ref_cta_tag']->title ?? 'Downstream Assets') }}</span>
        <h2 class="ref-cta-title">{!! _t($p['ref_cta_title']->title ?? 'Fuel Retail<br>Network.') !!}</h2>
        <p class="ref-cta-desc">
            {{ _t($p['ref_cta_desc']->title ?? '') }}
        </p>
        <div class="ref-cta-btns">
            <a href="/fuel-retail" class="btn-primary">
                <span>{{ _t($p['btn_fuel_retail_network']->title ?? 'Fuel Retail Network') }}</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="/upstream" class="btn-secondary" style="border-color:rgba(255,255,255,0.2);color:rgba(255,255,255,0.7);">{{ _t($p['btn_ups_downstream']->title ?? 'Upstream & Downstream') }}</a>
        </div>
    </div>
</section>


<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo('.ref-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
    });

    const refHeroBg = document.getElementById('refHeroBg');
    if (refHeroBg) {
        gsap.to(refHeroBg, {
            yPercent: 18, ease: 'none',
            scrollTrigger: { trigger: '.ref-hero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    gsap.utils.toArray('.ref-anim2').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 28 }, {
            opacity: 1, y: 0, duration: 0.9, delay: i * 0.12, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    gsap.utils.toArray('.ref-head-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.ref-prod-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 24 }, {
            opacity: 1, y: 0, duration: 0.7, delay: (i % 3) * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });
</script>

</x-public-layout>
