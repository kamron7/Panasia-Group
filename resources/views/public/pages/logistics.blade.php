<x-public-layout>

<style>
    /* ── HERO ── */
    .log-hero {
        min-height: 72vh; padding: 0;
        background: var(--bg-dark);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .log-hero-bg {
        position: absolute; inset: 0;
        background: url('/assets/public/images/logistics-hero.jpg') center/cover no-repeat;
    }
    .log-hero-bg::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(2,12,26,0.9) 0%, rgba(10,32,64,0.78) 50%, rgba(2,12,26,0.94) 100%);
    }
    .log-hero::before {
        content: 'LOGISTICS';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 14vw; font-weight: 700;
        color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 2;
    }
    .log-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 3;
        padding: 180px 5% 90px;
    }
    .log-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        margin-bottom: 22px; display: block; text-transform: uppercase;
    }
    .log-title {
        font-family: var(--font-head);
        font-size: clamp(3rem, 7vw, 6.5rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
    }
    .log-title .t-blue { color: var(--blue); }
    .log-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.8;
        max-width: 560px;
    }

    /* ── INTRO ── */
    .log-intro { background: var(--bg); padding: 100px 5%; }
    .log-intro-inner { max-width: var(--container); margin: 0 auto; }
    .log-intro-quote {
        font-family: var(--font-head);
        font-size: clamp(1.5rem, 2.8vw, 2.4rem);
        font-weight: 700; line-height: 1.15;
        letter-spacing: -0.025em; color: var(--text);
        max-width: 820px; margin-bottom: 28px;
    }
    .log-intro-quote span { color: var(--blue); }
    .log-intro-body { font-size: 1rem; color: var(--text-muted); line-height: 1.85; max-width: 680px; }

    /* ── HUB LOCATIONS ── */
    .log-hubs {
        background: var(--bg-alt); padding: 110px 5%;
    }
    .log-hubs-inner { max-width: var(--container); margin: 0 auto; }
    .log-hubs-head { margin-bottom: 64px; }

    .log-hub-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
    }
    .log-hub-card {
        border: 1px solid var(--border); border-radius: 16px;
        padding: 36px 28px; background: var(--bg);
        transition: all 0.3s; position: relative; overflow: hidden;
    }
    .log-hub-card:hover {
        border-color: rgba(34,119,187,0.3);
        box-shadow: 0 12px 40px rgba(34,119,187,0.08);
        transform: translateY(-3px);
    }
    .log-hub-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: var(--blue); transform: scaleX(0); transform-origin: left;
        transition: transform 0.4s ease;
    }
    .log-hub-card:hover::before { transform: scaleX(1); }
    .lhc-flag {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.2em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 12px; display: block;
    }
    .lhc-country {
        font-family: var(--font-head); font-size: 1.1rem;
        color: var(--text); font-weight: 700; margin-bottom: 12px;
        letter-spacing: -0.01em;
    }
    .lhc-ports {
        display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px;
    }
    .lhc-port {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.1em; text-transform: uppercase;
        padding: 4px 10px; border-radius: 20px;
        background: var(--bg-alt); border: 1px solid var(--border);
        color: var(--text-muted);
    }
    .lhc-desc { font-size: 0.875rem; color: var(--text-muted); line-height: 1.65; }

    /* ── CORRIDORS ── */
    .log-corridors {
        background: var(--bg-dark) url('/assets/public/images/maritime-logistics.jpg') center/cover no-repeat;
        padding: 110px 5%;
        position: relative; overflow: hidden;
    }
    .log-corridors::before {
        content: ''; position: absolute; inset: 0;
        background:
            radial-gradient(ellipse at 50% 75%, rgba(34,119,187,0.13) 0%, transparent 60%),
            linear-gradient(135deg, rgba(2,12,26,0.94) 0%, rgba(5,20,50,0.92) 50%, rgba(2,12,26,0.96) 100%);
        pointer-events: none; z-index: 0;
    }
    .log-corridors-inner { max-width: var(--container); margin: 0 auto; position: relative; z-index: 1; }
    .log-corridors-head { margin-bottom: 70px; }
    .log-corridors-head .section-title { color: #fff; }
    .log-corridors-head .section-tag   { color: var(--orange); }

    .log-corridor-list { display: flex; flex-direction: column; gap: 0; }
    .log-corridor {
        padding: 44px 0;
        border-top: 1px solid rgba(255,255,255,0.07);
        display: grid; grid-template-columns: 240px 1fr; gap: 48px; align-items: start;
    }
    .log-corridor:last-child { border-bottom: 1px solid rgba(255,255,255,0.07); }
    .lc-label {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 8px; display: block;
    }
    .lc-name {
        font-family: var(--font-head); font-size: 1.05rem;
        color: #fff; font-weight: 700; line-height: 1.25;
        letter-spacing: -0.01em;
    }
    .lc-steps {
        display: flex; flex-wrap: wrap; align-items: center; gap: 0;
    }
    .lc-step {
        display: flex; align-items: center; gap: 0;
    }
    .lc-node {
        font-family: var(--font-head); font-size: 0.8rem;
        color: rgba(255,255,255,0.92); font-weight: 600;
        padding: 6px 14px; border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.18);
        white-space: nowrap;
        text-shadow: 0 1px 6px rgba(0,0,0,0.6);
    }
    .lc-arrow {
        color: var(--blue); padding: 0 8px; font-size: 1rem;
        font-weight: 300; opacity: 0.7;
    }
    .lc-note {
        font-size: 0.8rem; color: rgba(255,255,255,0.55);
        padding: 4px 12px; font-style: italic;
        white-space: nowrap;
    }

    /* ── CTA ── */
    .log-cta {
        background: var(--bg); padding: 100px 5%; text-align: center;
    }
    .log-cta-inner { max-width: 560px; margin: 0 auto; }
    .log-cta-tag {
        font-family: var(--font-head); font-size: 10px;
        color: var(--orange); letter-spacing: 0.18em; text-transform: uppercase;
        margin-bottom: 20px; display: block;
    }
    .log-cta-title {
        font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3.5rem);
        color: var(--text); font-weight: 700; line-height: 1.05;
        letter-spacing: -0.025em; margin-bottom: 16px; text-transform: uppercase;
    }
    .log-cta-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 36px; }
    .log-cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    @media (max-width: 1024px) {
        .log-hub-grid { grid-template-columns: 1fr 1fr; }
        .log-corridor { grid-template-columns: 1fr; gap: 16px; }
    }
    @media (max-width: 640px) {
        .log-hub-grid { grid-template-columns: 1fr; }
        .lc-steps { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 600px) {
        .log-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
    }
</style>


{{-- HERO --}}
<section class="log-hero">
    <div class="log-hero-bg" id="logHeroBg"></div>
    <div class="log-hero-inner">
        <span class="log-eyebrow log-anim">{{ _t($p['log_hero_eyebrow']->title ?? 'Infrastructure & Logistics') }}</span>
        <h1 class="log-title log-anim">
            {{ _t($p['log_hero_title1']->title ?? 'Storage, Terminals') }}<br>&amp; <span class="t-blue">{{ _t($p['log_hero_title2']->title ?? 'Transshipment.') }}</span>
        </h1>
        <p class="log-hero-desc log-anim">
            {{ _t($p['log_hero_desc']->title ?? '') }}
        </p>
    </div>
</section>


{{-- INTRO --}}
<section class="log-intro">
    <div class="log-intro-inner">
        <p class="log-intro-quote log-anim2">
            {!! _t($p['log_intro_quote']->title ?? '') !!}
        </p>
        <p class="log-intro-body log-anim2">
            {{ _t($p['log_intro_body']->title ?? '') }}
        </p>
    </div>
</section>


{{-- HUB LOCATIONS --}}
<section class="log-hubs">
    <div class="log-hubs-inner">
        <div class="log-hubs-head">
            <span class="section-tag log-head-anim">{{ _t($p['log_hubs_tag']->title ?? 'Storage & Terminal Network') }}</span>
            <h2 class="section-title log-head-anim">{{ _t($p['log_hubs_title']->title ?? 'Key Infrastructure Hubs') }}</h2>
        </div>
        <div class="log-hub-grid">
            @if(isset($log_hubs) && $log_hubs->isNotEmpty())
                @foreach($log_hubs as $hub)
                <div class="log-hub-card log-hub-anim">
                    @if(!empty($hub->options))
                        <span class="lhc-flag">{{ $hub->options }}</span>
                    @endif
                    <div class="lhc-country">{{ _t($hub->title) }}</div>
                    @if(!empty($hub->options2))
                    <div class="lhc-ports">
                        @foreach(array_map('trim', explode(',', $hub->options2)) as $port)
                            <span class="lhc-port">{{ $port }}</span>
                        @endforeach
                    </div>
                    @endif
                    <p class="lhc-desc">{!! _t($hub->short_content) !!}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- CORRIDORS --}}
<section class="log-corridors">

    {{-- Canvas transport animation background --}}
    <canvas id="corrBg" aria-hidden="true" style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:0;"></canvas>

    <div class="log-corridors-inner">
        <div class="log-corridors-head">
            <span class="section-tag log-corr-anim">{{ _t($p['log_corridors_tag']->title ?? 'Supply Routes') }}</span>
            <h2 class="section-title log-corr-anim" style="color:#fff;">{!! _t($p['log_corridors_title']->title ?? 'Key Transportation<br>Corridors') !!}</h2>
        </div>
        <div class="log-corridor-list">
            @if(isset($log_corridors) && $log_corridors->isNotEmpty())
                @foreach($log_corridors as $corridor)
                <div class="log-corridor log-corr-item">
                    <div>
                        @if(!empty($corridor->options))
                            <span class="lc-label">{{ $corridor->options }}</span>
                        @endif
                        <div class="lc-name">{{ _t($corridor->title) }}</div>
                    </div>
                    <div>
                        <div class="lc-steps">
                            @if(!empty($corridor->options2))
                                @foreach(explode('|', $corridor->options2) as $node)
                                @php $n = trim($node); @endphp
                                <div class="lc-step">
                                    @if(str_starts_with($n, '('))
                                        <span class="lc-note">{{ $n }}</span>
                                    @else
                                        <span class="lc-node">{{ $n }}</span>
                                    @endif
                                    @if(!$loop->last)<span class="lc-arrow">→</span>@endif
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- CTA --}}
<section class="log-cta">
    <div class="log-cta-inner">
        <span class="log-cta-tag">{{ _t($p['log_cta_tag']->title ?? 'Work With Us') }}</span>
        <h2 class="log-cta-title">{!! _t($p['log_cta_title']->title ?? 'Connect Your<br>Supply Chain.') !!}</h2>
        <p class="log-cta-desc">
            {{ _t($p['log_cta_desc']->title ?? '') }}
        </p>
        <div class="log-cta-btns">
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
    /* ── CORRIDORS CANVAS BACKGROUND ── */
    (function () {
        const canvas = document.getElementById('corrBg');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let W, H;

        function resize() {
            const rect = canvas.parentElement.getBoundingClientRect();
            W = canvas.width  = rect.width  || window.innerWidth;
            H = canvas.height = rect.height || 600;
        }
        resize();
        window.addEventListener('resize', resize);

        /* Catmull-Rom spline – pts in normalized [0-1] space */
        function cr(pts, t) {
            const n = pts.length;
            const sf = Math.min(t, 0.9999) * (n - 1);
            const s  = Math.floor(sf), u = sf - s;
            const p0 = pts[Math.max(0, s-1)], p1 = pts[s];
            const p2 = pts[Math.min(n-1, s+1)], p3 = pts[Math.min(n-1, s+2)];
            const u2 = u*u, u3 = u2*u;
            return [
                0.5*(2*p1[0]+(-p0[0]+p2[0])*u+(2*p0[0]-5*p1[0]+4*p2[0]-p3[0])*u2+(-p0[0]+3*p1[0]-3*p2[0]+p3[0])*u3),
                0.5*(2*p1[1]+(-p0[1]+p2[1])*u+(2*p0[1]-5*p1[1]+4*p2[1]-p3[1])*u2+(-p0[1]+3*p1[1]-3*p2[1]+p3[1])*u3)
            ];
        }
        function pt(cps, t) { const [nx,ny]=cr(cps,t); return [nx*W, ny*H]; }

        /* Route definitions – rgb: track color, glow: highlight/particle color */
        const ROUTES = [
            {
                cps: [[-0.02,0.20],[0.10,0.13],[0.26,0.26],[0.44,0.18],[0.60,0.12],[0.76,0.19],[0.92,0.26],[1.02,0.22]],
                rgb:[34,119,187], glow:[80,170,255],
                lw:3, speed:0.00020,
                particles:[{t:0.04,trail:[]},{t:0.54,trail:[]}],
                hubs:[0.26,0.44,0.60,0.76]
            },
            {
                cps: [[-0.02,0.50],[0.12,0.43],[0.30,0.56],[0.48,0.49],[0.65,0.43],[0.81,0.50],[0.96,0.56],[1.02,0.52]],
                rgb:[249,115,22], glow:[255,160,60],
                lw:2.5, speed:0.00016,
                particles:[{t:0.22,trail:[]},{t:0.72,trail:[]}],
                hubs:[0.30,0.48,0.65,0.81]
            },
            {
                cps: [[-0.02,0.78],[0.16,0.72],[0.36,0.83],[0.56,0.76],[0.74,0.71],[0.90,0.77],[1.02,0.80]],
                rgb:[80,200,255], glow:[140,230,255],
                lw:2, speed:0.00013,
                particles:[{t:0.38,trail:[]}],
                hubs:[0.36,0.56,0.74]
            }
        ];

        /* Cross-connections between routes */
        const LINKS = [
            [ROUTES[0],0.44,ROUTES[1],0.48],
            [ROUTES[0],0.60,ROUTES[1],0.65],
            [ROUTES[0],0.76,ROUTES[1],0.81],
            [ROUTES[1],0.48,ROUTES[2],0.56]
        ];

        let last=0, t0=0;

        function frame(ts) {
            if (!t0) t0 = ts;
            const dt = Math.min(ts-last, 50);
            last = ts;
            const elapsed = ts - t0;

            ctx.clearRect(0,0,W,H);

            /* subtle dot-grid for depth */
            ctx.save();
            const gs = 50;
            for (let x=gs/2; x<W; x+=gs) {
                for (let y=gs/2; y<H; y+=gs) {
                    ctx.beginPath();
                    ctx.arc(x, y, 0.65, 0, Math.PI*2);
                    ctx.fillStyle = 'rgba(34,119,187,0.07)';
                    ctx.fill();
                }
            }
            ctx.restore();

            ROUTES.forEach((route, ri) => {
                const [r,g,b]=route.rgb, [gr,gg,gb]=route.glow;
                const STEPS = 400;

                function drawPath() {
                    ctx.beginPath();
                    for (let i=0; i<=STEPS; i++) {
                        const [x,y]=pt(route.cps, i/STEPS);
                        i ? ctx.lineTo(x,y) : ctx.moveTo(x,y);
                    }
                }

                /* outer glow */
                ctx.save(); drawPath();
                ctx.strokeStyle = `rgba(${gr},${gg},${gb},0.06)`;
                ctx.lineWidth = route.lw*10; ctx.lineCap='round'; ctx.stroke(); ctx.restore();

                /* mid glow */
                ctx.save(); drawPath();
                ctx.strokeStyle = `rgba(${gr},${gg},${gb},0.13)`;
                ctx.lineWidth = route.lw*4; ctx.lineCap='round'; ctx.stroke(); ctx.restore();

                /* core track */
                ctx.save(); drawPath();
                ctx.strokeStyle = `rgba(${r},${g},${b},0.42)`;
                ctx.lineWidth = route.lw; ctx.lineCap='round'; ctx.stroke(); ctx.restore();

                /* hub nodes with pulsing rings */
                route.hubs.forEach((t, hi) => {
                    const [x,y] = pt(route.cps, t);
                    const phase = elapsed*0.0016 + hi*1.2 + ri*2.1;
                    const pulse = (Math.sin(phase)+1)*0.5;

                    /* expanding pulse ring */
                    ctx.save();
                    ctx.beginPath(); ctx.arc(x, y, 5+pulse*14, 0, Math.PI*2);
                    ctx.strokeStyle = `rgba(${r},${g},${b},${(1-pulse)*0.22})`;
                    ctx.lineWidth = 1; ctx.stroke(); ctx.restore();

                    /* fixed outer ring */
                    ctx.save();
                    ctx.beginPath(); ctx.arc(x, y, 5, 0, Math.PI*2);
                    ctx.strokeStyle = `rgba(${r},${g},${b},0.6)`;
                    ctx.lineWidth = 1.5;
                    ctx.shadowColor = `rgba(${r},${g},${b},0.4)`; ctx.shadowBlur = 10;
                    ctx.stroke();

                    /* inner dot */
                    ctx.beginPath(); ctx.arc(x, y, 2.5, 0, Math.PI*2);
                    ctx.fillStyle = `rgba(${gr},${gg},${gb},1)`;
                    ctx.shadowColor = `rgba(${gr},${gg},${gb},0.8)`; ctx.shadowBlur = 16;
                    ctx.fill(); ctx.restore();
                });

                /* particles */
                route.particles.forEach(p => {
                    p.t += route.speed * dt;
                    if (p.t > 1) { p.t -= 1; p.trail.length = 0; }
                    const pos = pt(route.cps, p.t);
                    p.trail.push([...pos]);
                    if (p.trail.length > 45) p.trail.shift();

                    /* tapered glowing trail */
                    for (let i=1; i<p.trail.length; i++) {
                        const f = i / p.trail.length;
                        ctx.save();
                        ctx.beginPath();
                        ctx.moveTo(p.trail[i-1][0], p.trail[i-1][1]);
                        ctx.lineTo(p.trail[i][0],   p.trail[i][1]);
                        ctx.strokeStyle = `rgba(${gr},${gg},${gb},${f*f*0.75})`;
                        ctx.lineWidth = route.lw*f*1.6; ctx.lineCap='round'; ctx.stroke(); ctx.restore();
                    }

                    /* radial halo */
                    ctx.save();
                    const hg = ctx.createRadialGradient(pos[0],pos[1],0, pos[0],pos[1],18);
                    hg.addColorStop(0,   `rgba(${gr},${gg},${gb},0.85)`);
                    hg.addColorStop(0.45,`rgba(${gr},${gg},${gb},0.25)`);
                    hg.addColorStop(1,   `rgba(${gr},${gg},${gb},0)`);
                    ctx.beginPath(); ctx.arc(pos[0],pos[1],18,0,Math.PI*2);
                    ctx.fillStyle = hg; ctx.fill(); ctx.restore();

                    /* bright white core */
                    ctx.save();
                    ctx.beginPath(); ctx.arc(pos[0],pos[1],4.5,0,Math.PI*2);
                    ctx.fillStyle = '#fff';
                    ctx.shadowColor = `rgba(${gr},${gg},${gb},1)`; ctx.shadowBlur = 28;
                    ctx.fill(); ctx.restore();
                });
            });

            /* dashed cross-connections */
            LINKS.forEach(([r1,t1,r2,t2]) => {
                const [x1,y1]=pt(r1.cps,t1), [x2,y2]=pt(r2.cps,t2);
                ctx.save(); ctx.setLineDash([4,8]);
                ctx.beginPath(); ctx.moveTo(x1,y1); ctx.lineTo(x2,y2);
                ctx.strokeStyle='rgba(34,119,187,0.14)'; ctx.lineWidth=1; ctx.stroke(); ctx.restore();
            });

            requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    })();

    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo('.log-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
    });

    const logHeroBg = document.getElementById('logHeroBg');
    if (logHeroBg) {
        gsap.to(logHeroBg, {
            yPercent: 18, ease: 'none',
            scrollTrigger: { trigger: '.log-hero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    gsap.utils.toArray('.log-anim2').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 28 }, {
            opacity: 1, y: 0, duration: 0.9, delay: i * 0.14, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    gsap.utils.toArray('.log-head-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.log-hub-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 30 }, {
            opacity: 1, y: 0, duration: 0.75, delay: (i % 3) * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.log-corr-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.log-corr-item').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, x: -28 }, {
            opacity: 1, x: 0, duration: 0.85, delay: i * 0.12, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });
</script>

</x-public-layout>
