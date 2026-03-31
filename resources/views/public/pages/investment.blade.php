<x-public-layout>

<style>
    /* ── HERO ── */
    .inv-hero {
        min-height: 72vh; padding: 0;
        background: var(--bg-dark);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .inv-hero-bg {
        position: absolute; inset: 0;
        background: url('/assets/public/images/investment-hero.jpg') center/cover no-repeat;
    }
    .inv-hero-bg::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(2,12,26,0.9) 0%, rgba(10,32,64,0.8) 50%, rgba(2,12,26,0.92) 100%);
    }
    .inv-hero::before {
        content: 'INVEST';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 22vw; font-weight: 700;
        color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 2;
    }
    .inv-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 3;
        padding: 180px 5% 90px;
    }
    .inv-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        margin-bottom: 22px; display: block; text-transform: uppercase;
    }
    .inv-title {
        font-family: var(--font-head);
        font-size: clamp(3.5rem, 8vw, 7.5rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
    }
    .inv-title .t-blue { color: var(--blue); }
    .inv-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.8;
        max-width: 540px;
    }

    /* ── INTRO STATEMENT ── */
    .inv-intro {
        background: var(--bg); padding: 100px 5%;
    }
    .inv-intro-inner {
        max-width: var(--container); margin: 0 auto;
        display: grid; grid-template-columns: 1fr 400px; gap: 80px; align-items: center;
    }
    .inv-intro-quote {
        font-family: var(--font-head);
        font-size: clamp(1.6rem, 3vw, 2.5rem);
        font-weight: 700; line-height: 1.15;
        letter-spacing: -0.025em; color: var(--text);
    }
    .inv-intro-quote span { color: var(--blue); }
    .inv-intro-body {
        font-size: 1rem; color: var(--text-muted); line-height: 1.85; margin-top: 24px;
    }
    .inv-target-box {
        background: var(--bg-dark); border-radius: 20px;
        padding: 44px 36px; text-align: center;
        border: 1px solid rgba(34,119,187,0.2);
    }
    .itb-label {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.2em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 16px; display: block;
    }
    .itb-num {
        font-family: var(--font-head); font-size: 3.5rem;
        font-weight: 700; color: #fff; letter-spacing: -0.04em;
        line-height: 1;
    }
    .itb-num span { color: var(--blue); font-size: 2rem; }
    .itb-sub { font-size: 0.85rem; color: rgba(255,255,255,0.45); margin-top: 10px; line-height: 1.5; }

    /* ── STRATEGY PILLARS ── */
    .inv-pillars {
        background: var(--bg-dark); padding: 110px 5%;
        position: relative; overflow: hidden;
    }
    .inv-pillars::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse at 80% 40%, rgba(34,119,187,0.12) 0%, transparent 65%);
        pointer-events: none;
    }
    .inv-pillars-inner { max-width: var(--container); margin: 0 auto; }
    .inv-pillars-head { margin-bottom: 70px; }
    .inv-pillars-head .section-tag { color: var(--orange); }
    .inv-pillars-head .section-title { color: #fff; }

    .inv-pillar-list { display: flex; flex-direction: column; gap: 0; }
    .inv-pillar {
        display: grid; grid-template-columns: 80px 1fr 1fr;
        gap: 48px; align-items: start;
        padding: 52px 0;
        border-top: 1px solid rgba(255,255,255,0.07);
        position: relative;
    }
    .inv-pillar:last-child { border-bottom: 1px solid rgba(255,255,255,0.07); }
    .inv-pillar:hover .ip-num { color: var(--blue); }
    .ip-num {
        font-family: var(--font-head); font-size: 4.5rem; font-weight: 700;
        color: rgba(255,255,255,0.06); letter-spacing: -0.05em; line-height: 1;
        transition: color 0.4s;
    }
    .ip-left {}
    .ip-tag {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 12px; display: block;
    }
    .ip-title {
        font-family: var(--font-head); font-size: clamp(1.2rem, 2vw, 1.7rem);
        color: #fff; font-weight: 700; letter-spacing: -0.02em; line-height: 1.15;
    }
    .ip-desc {
        font-size: 0.95rem; color: rgba(255,255,255,0.5); line-height: 1.8;
        padding-top: 8px;
    }

    /* ── CTA ── */
    .inv-cta {
        background: var(--bg); padding: 100px 5%; text-align: center;
    }
    .inv-cta-inner { max-width: 560px; margin: 0 auto; }
    .inv-cta-tag {
        font-family: var(--font-head); font-size: 10px;
        color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
        margin-bottom: 20px; display: block;
    }
    .inv-cta-title {
        font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.5rem);
        color: var(--text); font-weight: 700; line-height: 1.05;
        letter-spacing: -0.025em; margin-bottom: 16px; text-transform: uppercase;
    }
    .inv-cta-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 36px; }
    .inv-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    @media (max-width: 1024px) {
        .inv-intro-inner { grid-template-columns: 1fr; }
        .inv-target-box { max-width: 340px; }
        .inv-pillar { grid-template-columns: 60px 1fr; }
        .ip-desc { grid-column: 2; }
    }
    @media (max-width: 640px) {
        .inv-pillar { grid-template-columns: 1fr; gap: 16px; }
        .ip-num { font-size: 3rem; }
    }

    @media (max-width: 600px) {
        .inv-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
    }
</style>


{{-- HERO --}}
<section class="inv-hero">
    <div class="inv-hero-bg" id="invHeroBg"></div>
    <div class="inv-hero-inner">
        <span class="inv-eyebrow inv-anim">{{ _t($p['inv_hero_eyebrow']->title ?? 'Investment Strategy') }}</span>
        <h1 class="inv-title inv-anim">
            {{ _t($p['inv_hero_title1']->title ?? 'Strategic') }}<br>
            <span class="t-blue">{{ _t($p['inv_hero_title2']->title ?? 'Investment.') }}</span>
        </h1>
        <p class="inv-hero-desc inv-anim">
            {{ _t($p['inv_hero_desc']->title ?? '') }}
        </p>
    </div>
</section>


{{-- INTRO STATEMENT --}}
<section class="inv-intro">
    <div class="inv-intro-inner">
        <div>
            <p class="inv-intro-quote inv-anim2">
                {!! _t($p['inv_intro_quote']->title ?? '') !!}
            </p>
            <p class="inv-intro-body inv-anim2">
                {{ _t($p['inv_intro_body']->title ?? '') }}
            </p>
        </div>
        <div class="inv-target-box inv-anim2">
            <span class="itb-label">{{ _t($p['inv_target_label']->title ?? 'Target Portfolio Capitalization') }}</span>
            <div class="itb-num">{{ _t($p['inv_target_currency']->title ?? 'USD') }} <span>{{ _t($p['inv_target_num']->title ?? '1B') }}</span></div>
            <p class="itb-sub">
                {{ _t($p['inv_target_sub']->title ?? '') }}
            </p>
        </div>
    </div>
</section>


{{-- STRATEGY PILLARS --}}
<section class="inv-pillars">
    <div class="inv-pillars-inner">
        <div class="inv-pillars-head">
            <span class="section-tag inv-head-anim">{{ _t($p['inv_pillars_tag']->title ?? 'Our Approach') }}</span>
            <h2 class="section-title inv-head-anim" style="color:#fff;">{{ _t($p['inv_pillars_title']->title ?? 'Four Strategic Pillars') }}</h2>
        </div>

        <div class="inv-pillar-list">
            @if(isset($inv_pillars) && $inv_pillars->isNotEmpty())
                @foreach($inv_pillars as $pillar)
                <div class="inv-pillar inv-pillar-anim">
                    <div class="ip-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="ip-left">
                        <span class="ip-tag">{{ _t($pillar->short_content) }}</span>
                        <h3 class="ip-title">{!! nl2br(e(_t($pillar->title))) !!}</h3>
                    </div>
                    <p class="ip-desc">{!! _t($pillar->content) !!}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- CTA --}}
<section class="inv-cta">
    <div class="inv-cta-inner">
        <span class="inv-cta-tag">{{ _t($p['inv_cta_tag']->title ?? 'Partner With Us') }}</span>
        <h2 class="inv-cta-title">{!! _t($p['inv_cta_title']->title ?? 'Invest in<br>Energy.') !!}</h2>
        <p class="inv-cta-desc">
            {{ _t($p['inv_cta_desc']->title ?? '') }}
        </p>
        <div class="inv-cta-btns">
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

    gsap.fromTo('.inv-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
    });

    const invHeroBg = document.getElementById('invHeroBg');
    if (invHeroBg) {
        gsap.to(invHeroBg, {
            yPercent: 18, ease: 'none',
            scrollTrigger: { trigger: '.inv-hero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    gsap.utils.toArray('.inv-anim2').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 28 }, {
            opacity: 1, y: 0, duration: 0.9, delay: i * 0.14, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    gsap.utils.toArray('.inv-head-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.inv-pillar-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, x: -32 }, {
            opacity: 1, x: 0, duration: 0.9, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });
</script>

</x-public-layout>
