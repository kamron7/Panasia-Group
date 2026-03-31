<x-public-layout>

<style>
    /* ── Hero (identical to contacts/services/projects) ── */
    .page-hero {
        min-height: 68vh; padding: 0;
        background: var(--bg-dark);
        position: relative; z-index: 2; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .page-hero-bg {
        position: absolute; inset: 0; z-index: 0;
        background: url('/assets/public/images/about-hero.avif') center/cover no-repeat;
    }
    .page-hero-bg::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(2,12,26,0.88) 0%, rgba(10,32,64,0.78) 50%, rgba(2,12,26,0.92) 100%);
    }
    .page-hero::before {
        content: 'ABOUT';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 22vw; font-weight: 700;
        color: rgba(255,255,255,0.03); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 2;
    }
    .page-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 3;
        padding: 180px 5% 80px;
    }
    .page-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.18em; color: var(--orange);
        margin-bottom: 20px; display: block; text-transform: uppercase;
    }
    .page-title {
        font-family: var(--font-head);
        font-size: clamp(3.5rem, 8vw, 8rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; margin-bottom: 32px; text-transform: uppercase;
    }
    .page-title .t-blue { color: var(--blue); }
    .page-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.65); line-height: 1.8;
        max-width: 540px;
    }

    /* ── Mission ── */
    .mission-section {
        background: var(--bg-alt); padding: 100px 5%;
        position: relative; overflow: hidden;
    }
    .mission-inner {
        max-width: var(--container); margin: 0 auto;
        display: grid; grid-template-columns: 1fr 340px; gap: 80px;
        align-items: start;
    }
    .mission-tag {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 20px; display: block;
    }
    .mission-heading {
        font-family: var(--font-head); font-size: clamp(1.4rem, 2vw, 1.75rem);
        font-weight: 700; line-height: 1.2; letter-spacing: -0.015em;
        color: var(--text); margin-bottom: 18px;
    }
    .mission-body {
        font-size: 1rem; color: var(--text-muted); line-height: 1.9;
        border-left: 2px solid var(--orange); padding-left: 20px;
    }
    .mission-right {
        border-left: 1px solid var(--border); padding-left: 52px;
        display: flex; flex-direction: column; gap: 32px;
        padding-top: 40px;
    }
    .mission-stat { display: flex; flex-direction: column; gap: 6px; }
    .ms-num {
        font-family: var(--font-head); font-size: 2.2rem;
        font-weight: 700; color: var(--text); letter-spacing: -0.04em; line-height: 1;
    }
    .ms-num span { color: var(--orange); }
    .ms-lbl { font-size: 0.78rem; color: var(--text-muted); letter-spacing: 0.04em; }

    /* ── Group Structure Org Chart ── */
    .entities-section {
        background: var(--bg-alt); padding: 100px 5%;
    }
    .entities-inner { max-width: var(--container); margin: 0 auto; }
    .entities-head { margin-bottom: 70px; }

    /* Org chart layout */
    .org-chart { display: flex; flex-direction: column; align-items: center; }

    /* Parent / holding node */
    .org-parent {
        background: var(--bg-dark);
        border: 1px solid rgba(34,119,187,0.35);
        border-radius: 16px; padding: 32px 44px;
        text-align: center; position: relative;
        box-shadow: 0 8px 40px rgba(34,119,187,0.12);
        min-width: 320px;
    }
    .org-parent-label {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.2em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 10px; display: block;
    }
    .org-parent-name {
        font-family: var(--font-head); font-size: 1.25rem;
        color: #fff; font-weight: 700; line-height: 1.2;
        letter-spacing: -0.01em;
    }
    .org-parent-sub {
        font-size: 0.8rem; color: rgba(255,255,255,0.45);
        margin-top: 6px;
    }

    /* Connector trunk */
    .org-trunk {
        width: 1px; height: 48px;
        background: linear-gradient(to bottom, rgba(34,119,187,0.6), rgba(34,119,187,0.2));
        position: relative;
    }

    /* Horizontal bar */
    .org-bar-wrap {
        display: flex; align-items: flex-start;
        position: relative; width: 100%;
        justify-content: center;
    }
    .org-bar {
        position: absolute; top: 0; left: 50%; transform: translateX(-50%);
        width: 75%; height: 1px;
        background: rgba(34,119,187,0.35);
    }

    /* Child columns */
    .org-children {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 20px; width: 100%;
    }
    .org-child-col {
        display: flex; flex-direction: column; align-items: center;
    }
    .org-child-stem {
        width: 1px; height: 40px;
        background: rgba(34,119,187,0.3);
    }
    .org-ownership {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.12em; color: rgba(34,119,187,0.8);
        text-transform: uppercase; margin: 0 0 2px;
        display: flex; align-items: center; gap: 5px;
    }
    .org-ownership svg { opacity: 0.7; }

    /* Child entity cards */
    .entity-card {
        background: var(--bg); border: 1px solid var(--border);
         padding: 32px 28px;
        position: relative; overflow: hidden;
        transition: all 0.3s; width: 100%;
    }
    .entity-card:hover {
        border-color: rgba(34,119,187,0.35);
        box-shadow: 0 12px 40px rgba(34,119,187,0.08);
        transform: translateY(-4px);
    }
    .entity-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        border-radius: 16px 16px 0 0;
    }
    .entity-card:nth-child(1)::before { background: var(--blue); }
    .entity-card:nth-child(2)::before { background: var(--orange); }
    .entity-card:nth-child(3)::before { background: linear-gradient(90deg, var(--blue), var(--orange)); }
    .ec-num {
        font-family: var(--font-head); font-size: 0.7rem;
        color: var(--text-light); letter-spacing: 0.18em;
        text-transform: uppercase; margin-bottom: 20px; display: block;
    }
    .ec-name {
        font-family: var(--font-head); font-size: 1.05rem;
        color: var(--text); font-weight: 700; line-height: 1.3;
        margin-bottom: 12px; letter-spacing: -0.01em;
    }
    .ec-desc { font-size: 0.875rem; color: var(--text-muted); line-height: 1.7; }
    .ec-badge {
        margin-top: 20px; display: inline-block;
        font-family: var(--font-head); font-size: 8px;
        letter-spacing: 0.14em; text-transform: uppercase;
        padding: 5px 12px; border-radius: 20px;
        border: 1px solid var(--border); color: var(--text-light);
    }

    @media (max-width: 900px) {
        .org-children { grid-template-columns: 1fr; }
        .org-bar { width: 1px; }
        .org-parent { min-width: unset; width: 100%; }
    }

    .operations-section {
        background: var(--bg); padding: 100px 5%; overflow: hidden;
    }
    .operations-inner {
        max-width: var(--container); margin: 0 auto;
        display: grid; grid-template-columns: 400px 1fr; gap: 100px;
        align-items: center;
    }
    .ops-right { position: relative; min-height: 460px; }
    .ops-country {
        position: absolute;
        font-family: var(--font-head); font-weight: 700;
        color: var(--text); letter-spacing: -0.03em;
        cursor: default; transition: color 0.25s; white-space: nowrap;
    }
    .ops-country:hover { color: var(--blue); }
    .ops-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.2em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 20px; display: block;
    }
    .ops-title {
        font-family: var(--font-head); font-size: clamp(1.8rem, 3vw, 2.8rem);
        font-weight: 700; color: var(--text); letter-spacing: -0.03em;
        line-height: 1.1; margin-bottom: 20px;
    }
    .ops-desc {
        font-size: 0.95rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 36px;
    }
    .ops-link {
        display: inline-flex; align-items: center; gap: 8px;
        font-family: var(--font-head); font-size: 0.82rem; font-weight: 600;
        color: var(--blue); text-decoration: none; letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* ── History Timeline ── */
    .history-section {
        padding: 120px 5%; background: var(--bg-dark);
        position: relative; z-index: 2; overflow: hidden;
    }
    .history-head { max-width: 900px; margin: 0 auto 70px; }
    .history-head .section-title { color: #fff; }
    .history-head .section-tag   { color: var(--orange); }
    .history-track {
        position: relative; max-width: 900px; margin: 0 auto; padding: 40px 0;
    }
    .history-line {
        position: absolute; left: 50%; top: 0; bottom: 0; width: 1px;
        background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.1) 15%, rgba(255,255,255,0.1) 85%, transparent);
        transform: translateX(-50%); z-index: 1;
    }
    .history-event {
        position: relative; width: 50%; margin-bottom: 80px;
        padding: 0 60px; box-sizing: border-box;
        display: flex; flex-direction: column;
    }
    .history-event:last-child { margin-bottom: 0; }
    .history-event.left  { left: 0; text-align: right; align-items: flex-end; }
    .history-event.right { left: 50%; text-align: left; align-items: flex-start; }
    .h-dot {
        position: absolute; top: 24px; width: 10px; height: 10px;
        background: var(--bg-dark); border: 2px solid var(--orange);
        border-radius: 50%; z-index: 5; box-shadow: 0 0 14px rgba(255,124,16,0.5);
    }
    .left .h-dot  { right: -6px; }
    .right .h-dot { left: -6px; }
    .h-bg-year {
        position: absolute; top: -30px;
        font-family: var(--font-head); font-size: 9rem; font-weight: 700;
        line-height: 1; color: rgba(255,255,255,0.03);
        user-select: none; pointer-events: none;
    }
    .left .h-bg-year  { right: 10px; }
    .right .h-bg-year { left: 10px; }
    .h-card {
        position: relative; z-index: 2;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px; padding: 28px;
        transition: all 0.3s; max-width: 380px;
    }
    .h-card:hover { border-color: rgba(255,255,255,0.2); transform: translateY(-4px); }
    .h-year-tag {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; display: block; margin-bottom: 10px;
    }
    .h-card h3 { font-family: var(--font-head); color: #fff; margin-bottom: 10px; font-size: 1.1rem; }
    .h-card p  { font-size: 0.9rem; color: rgba(255,255,255,0.5); line-height: 1.65; }

    /* ── Values ── */
    .values-section { padding: 100px 0; background: var(--bg-alt); }
    .values-head { max-width: var(--container); margin: 0 auto 60px; padding: 0 5%; }
    .value-row {
        display: grid; grid-template-columns: 5% 180px 1fr 1fr 5%;
        align-items: center; gap: 0; padding: 52px 0;
        border-top: 1px solid var(--border); transition: background 0.3s;
    }
    .value-row:last-child { border-bottom: 1px solid var(--border); }
    .value-row:hover { background: #fff; }
    .vr-spacer {}
    .vr-num {
        font-family: var(--font-head); font-size: 6rem; font-weight: 700;
        color: rgba(0,0,0,0.04); letter-spacing: -0.06em; line-height: 1;
        padding-left: 5%; user-select: none; transition: color 0.3s;
    }
    .value-row:hover .vr-num { color: rgba(34,119,187,0.1); }
    .vr-label { padding: 0 40px; }
    .vr-tag {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 8px; display: block;
    }
    .vr-name {
        font-family: var(--font-head); font-size: 1.3rem;
        color: var(--text); font-weight: 700; letter-spacing: -0.02em;
    }
    .vr-desc { font-size: 0.95rem; color: var(--text-muted); line-height: 1.75; padding-right: 5%; }

    /* ── Parallax Break ── */
    .parallax-break {
        height: 440px; position: relative; overflow: hidden;
    }
    .parallax-break-img {
        position: absolute; top: -25%; left: 0; right: 0; bottom: -25%;
        background: center/cover no-repeat; will-change: transform;
    }
    .parallax-break-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(2,12,26,0.45) 0%, rgba(2,12,26,0.55) 100%);
    }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
        .mission-inner { grid-template-columns: 1fr; gap: 40px; }
        .mission-right { border-left: none; border-top: 1px solid var(--border); padding-left: 0; padding-top: 32px; flex-direction: row; flex-wrap: wrap; gap: 32px; }
        .entities-grid { grid-template-columns: 1fr; gap: 12px; }
        .operations-inner { grid-template-columns: 1fr; }
        .ops-right { display: none; }
        .value-row { grid-template-columns: 16px 120px 1fr 16px; }
        .vr-spacer { display: none; }
        .vr-desc { padding-right: 16px; }
    }
    @media (max-width: 768px) {
        .page-hero-inner { padding: 110px 5% 56px; }
        .mission-section { padding: 70px 5%; }
        .entities-section { padding: 70px 5%; }
        .operations-section { padding: 70px 5%; }
        .history-section { padding: 80px 5%; }
        .values-section { padding: 80px 0; }
        .history-line { left: 20px; }
        .history-event { width: 100%; padding-left: 50px; padding-right: 0; left: 0 !important; text-align: left !important; align-items: flex-start !important; }
        .left .h-dot { left: 14px !important; right: auto !important; }
        .right .h-dot { left: 14px; }
        .h-bg-year { left: 40px !important; right: auto !important; font-size: 5rem; }
        .value-row { grid-template-columns: 1fr; padding: 32px 5%; }
        .vr-num { font-size: 4rem; padding-left: 0; }
        .mission-right { flex-direction: column; gap: 24px; }
    }
    @media (max-width: 600px) {
        .page-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
        .page-hero-inner { padding: 96px 5% 44px; }
        .mission-section { padding: 56px 5%; }
        .entities-section { padding: 56px 5%; }
        .history-section { padding: 60px 5%; }
        .values-section { padding: 60px 0; }
        .mission-heading { font-size: 1.1rem; }
        .ms-num { font-size: 1.8rem; }
        .org-parent { padding: 24px 20px; }
        .entity-card { padding: 24px 20px; }
        .h-card { padding: 20px; }
    }


</style>


{{-- ────────────── HERO ────────────── --}}
<section class="page-hero">
    <div class="page-hero-bg" id="aboutHeroBg"></div>
    <div class="page-hero-inner">
        <span class="page-eyebrow ph-anim">{{ _t($p['about_eyebrow']->title ?? '') }}</span>
        <h1 class="page-title ph-anim">
            {{ _t($p['about_hero_line2']->title ?? '') }}<br>
            <span class="t-blue">{{ _t($p['about_hero_line3']->title ?? '') }}</span>
        </h1>
        <p class="page-hero-desc ph-anim">{{ _t($p['about_hero_desc']->title ?? '') }}</p>
    </div>
</section>


{{-- ────────────── MISSION ────────────── --}}
<section class="mission-section">
    <div class="mission-inner">
        <div class="mission-left">
            <span class="mission-tag ms-anim">{{ _t($p['our_mission']->title ?? '') }}</span>
            @if(!empty($mission))
                <h2 class="mission-heading ms-anim">{{ _t($mission->title) }}</h2>
                <div class="mission-body ms-anim">{!! _t($mission->content) !!}</div>
            @endif
        </div>
        <div class="mission-right ms-anim">
            @if(!empty($about_stats) && $about_stats->count())
                @foreach($about_stats->take(3) as $stat)
                <div class="mission-stat">
                    <div class="ms-num">{!! $stat->options !!}</div>
                    <div class="ms-lbl">{{ _t($stat->title) }}</div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- ────────────── PARALLAX BREAK ────────────── --}}
<div class="parallax-break">
    <div class="parallax-break-img" style="background-image:url('/assets/public/images/parallax-about-1.jpg');" data-parallax></div>
    <div class="parallax-break-overlay"></div>
</div>


{{-- ────────────── GROUP STRUCTURE ────────────── --}}
<section class="entities-section">
    <div class="entities-inner">
        <div class="entities-head">
            <span class="section-tag ent-anim">{{ _t($p['legal_structure']->title ?? '') }}</span>
            <h2 class="section-title ent-anim">{{ _t($p['our_three_entities']->title ?? '') }}</h2>
            <p class="section-subtitle ent-anim">{{ _t($p['entities_subtitle']->title ?? '') }}</p>
        </div>

        <div class="org-chart ent-card-anim">

            <div class="org-parent">
                <span class="org-parent-label">{{ !empty($org_parent) ? _t($org_parent->options) : _t($p['about_org_parent_label']->title ?? 'Parent Holding') }}</span>
                <div class="org-parent-name">{{ !empty($org_parent) ? _t($org_parent->title) : _t($p['about_org_parent_name']->title ?? 'PANASIA HOLDING LIMITED') }}</div>
                <div class="org-parent-sub">{{ !empty($org_parent) ? _t($org_parent->options2) : _t($p['about_org_parent_sub']->title ?? 'Abu Dhabi, UAE') }}</div>
            </div>

            {{-- Trunk line --}}
            <div class="org-trunk"></div>

            {{-- Horizontal connector bar --}}
            <div class="org-bar-wrap" style="position:relative;width:100%;height:0;">
                <div class="org-bar"></div>
            </div>

            {{-- Three child entities --}}
            <div class="org-children" style="margin-top:0;">
                @php
                    $fallbackEntities = [
                        ['name' => _t($p['about_entity1_name']->title ?? 'PANASIA ENERGY DMCC'),     'location' => _t($p['about_entity1_loc']->title ?? 'Dubai, UAE'),     'desc' => _t($p['about_entity1_desc']->title ?? '')],
                        ['name' => _t($p['about_entity2_name']->title ?? 'PANASIA GAS TRADING LLC'), 'location' => _t($p['about_entity2_loc']->title ?? 'Dubai, UAE'),     'desc' => _t($p['about_entity2_desc']->title ?? '')],
                        ['name' => _t($p['about_entity3_name']->title ?? 'PANASIA INVESTMENT LLC'),  'location' => _t($p['about_entity3_loc']->title ?? 'Abu Dhabi, UAE'), 'desc' => _t($p['about_entity3_desc']->title ?? '')],
                    ];
                    $entityList = (!empty($about_entities) && $about_entities->count()) ? $about_entities->toArray() : [];
                @endphp

                @for($ei = 0; $ei < 3; $ei++)
                <div class="org-child-col">
                    <div class="org-child-stem"></div>
                    <div class="org-ownership">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                        {{ _t($p['about_ownership_label']->title ?? '100% Ownership') }}
                    </div>
                    <div class="entity-card">
                        <span class="ec-num">{{ str_pad($ei + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        @if(!empty($entityList[$ei]))
                            <div class="ec-name">{{ _t($entityList[$ei]['title'] ?? '') }}</div>
                            <p class="ec-desc">{!! _t($entityList[$ei]['short_content'] ?? '') !!}</p>
                            @if(!empty($entityList[$ei]['options']))
                                <span class="ec-badge">{{ $entityList[$ei]['options'] }}</span>
                            @endif
                        @else
                            <div class="ec-name">{{ $fallbackEntities[$ei]['name'] }}</div>
                            <p class="ec-desc">{{ $fallbackEntities[$ei]['desc'] }}</p>
                            <span class="ec-badge">{{ $fallbackEntities[$ei]['location'] }}</span>
                        @endif
                    </div>
                </div>
                @endfor
            </div>

        </div>
    </div>
</section>


{{-- ────────────── OPERATIONS ────────────── --}}
<section class="operations-section">
    <div class="operations-inner">
        <div class="ops-left">
            <span class="ops-eyebrow ops-anim">{{ _t($p['where_we_operate']->title ?? '') }}</span>
            <h2 class="ops-title ops-anim">{!! _t($p['active_countries']->title ?? '') !!}</h2>
            <p class="ops-desc ops-anim">{{ _t($p['ops_desc']->title ?? '') }}</p>
            <a href="/contacts" class="ops-link ops-anim">
                {{ _t($p['explore_partnerships']->title ?? '') }}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="ops-right ops-anim">
            @if(!empty($operations) && $operations->count())
                @foreach($operations as $op)
                <div class="ops-country">{{ _t($op->title) }}</div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- ────────────── HISTORY TIMELINE ────────────── --}}
<section class="history-section">
    <div class="history-head">
        <span class="section-tag hs-anim">{{ _t($p['our_journey']->title ?? '') }}</span>
        <h2 class="section-title hs-anim" style="color:#fff;">{{ _t($p['history_title']->title ?? '') }}</h2>
    </div>
    <div class="history-track">
        <div class="history-line"></div>
        @if(!empty($history) && $history->count())
            @foreach($history as $event)
            <div class="history-event {{ $loop->odd ? 'left' : 'right' }} history-anim">
                <div class="h-dot"></div>
                <div class="h-bg-year">{{ $event->options ?? '' }}</div>
                <div class="h-card">
                    @if($event->options)
                        <span class="h-year-tag">{{ $event->options }}</span>
                    @endif
                    <h3>{{ _t($event->title) }}</h3>
                    <p>{!! _t($event->content ?? $event->short_content ?? '') !!}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>


{{-- ────────────── VALUES ────────────── --}}
<section class="values-section">
    <div class="values-head">
        <span class="section-tag val-anim">{{ _t($p['what_drives_us']->title ?? '') }}</span>
        <h2 class="section-title val-anim">{{ _t($p['our_core_values']->title ?? '') }}</h2>
    </div>
    @if(!empty($values) && $values->count())
        @foreach($values as $value)
        <div class="value-row val-row-anim">
            <div class="vr-spacer"></div>
            <div class="vr-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="vr-label">
                <span class="vr-tag">{{ $value->options ?? '0' . $loop->iteration }}</span>
                <div class="vr-name">{{ _t($value->title) }}</div>
            </div>
            <div class="vr-desc">{!! _t($value->short_content ?? '') !!}</div>
            <div class="vr-spacer"></div>
        </div>
        @endforeach
    @endif
</section>


<script>
    gsap.registerPlugin(ScrollTrigger);

    /* ── Hero (exact same as contacts/services/projects) ── */
    gsap.fromTo('.ph-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18,
        ease: 'power3.out', delay: 0.3
    });

    /* Hero bg parallax */
    const aboutHeroBg = document.getElementById('aboutHeroBg');
    if (aboutHeroBg) {
        gsap.to(aboutHeroBg, {
            yPercent: 18, ease: 'none',
            scrollTrigger: { trigger: '.page-hero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }

    /* Mission */
    gsap.utils.toArray('.ms-anim').forEach((el, i) => {
        gsap.fromTo(el,
            { opacity: 0, y: 32 },
            { opacity: 1, y: 0, duration: 1.0, delay: i * 0.15, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 82%' } }
        );
    });

    /* Section titles */
    function splitReveal(selector) {
        document.querySelectorAll(selector).forEach(el => {
            const text = el.innerText;
            el.innerHTML = text.split(' ').map(w =>
                `<span style="display:inline-block;overflow:hidden;vertical-align:bottom"><span style="display:inline-block;transform:translateY(110%)">${w}</span></span>`
            ).join(' ');
            gsap.to(el.querySelectorAll('span > span'), {
                y: '0%', stagger: 0.06, duration: 1.0, ease: 'power4.out',
                scrollTrigger: { trigger: el, start: 'top 85%' }
            });
        });
    }
    splitReveal('.section-title');

    /* Entities */
    gsap.utils.toArray('.ent-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 },
            { opacity: 1, y: 0, duration: 0.8, delay: i * 0.12, ease: 'power3.out',
              scrollTrigger: { trigger: '.entities-section', start: 'top 75%' } }
        );
    });
    gsap.utils.toArray('.ent-card-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 40, scale: 0.97 },
            { opacity: 1, y: 0, scale: 1, duration: 0.9, delay: i * 0.14, ease: 'back.out(1.3)',
              scrollTrigger: { trigger: '.entities-grid', start: 'top 80%' } }
        );
    });

    /* Operations */
    gsap.utils.toArray('.ops-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, x: -40 },
            { opacity: 1, x: 0, duration: 1.0, delay: i * 0.12, ease: 'power3.out',
              scrollTrigger: { trigger: '.operations-section', start: 'top 75%' } }
        );
    });
    /* ── Collision-aware country label placement ── */
    (function () {
        const container = document.querySelector('.ops-right');
        const els = Array.from(document.querySelectorAll('.ops-country'));
        if (!els.length || !container) return;

        /* Visual variants assigned by index */
        const variants = [
            { size: '2.8rem',  color: 'var(--text)' },
            { size: '1.55rem', color: 'var(--text-muted)' },
            { size: '2.2rem',  color: 'var(--text)' },
            { size: '1.4rem',  color: 'var(--text-light)' },
            { size: '3.0rem',  color: 'var(--text)' },
            { size: '1.65rem', color: 'var(--text-muted)' },
            { size: '2.0rem',  color: 'var(--text-light)' },
            { size: '1.5rem',  color: 'var(--text-muted)' },
            { size: '2.4rem',  color: 'var(--text)' },
            { size: '1.7rem',  color: 'var(--text-light)' },
        ];

        /* Step 1 – apply font sizes, move off-screen so we can measure widths */
        els.forEach((el, i) => {
            const v = variants[i % variants.length];
            el.style.fontSize   = v.size;
            el.style.color      = v.color;
            el.style.visibility = 'hidden';
            el.style.left = '0px';
            el.style.top  = '0px';
        });

        /* Step 2 – after render: measure each label and place without overlap */
        requestAnimationFrame(() => {
            const CW  = container.offsetWidth;
            const CH  = container.offsetHeight;
            const PAD = 16; /* minimum gap between labels */

            /*
             * Candidate anchors [left%, top%] — 18 slots covering the container evenly.
             * Tried in order; first slot that doesn't overlap wins.
             */
            const slots = [
                [0.02, 0.02], [0.55, 0.00], [0.75, 0.06],
                [0.12, 0.30], [0.48, 0.28], [0.78, 0.32],
                [0.00, 0.56], [0.42, 0.56], [0.68, 0.54],
                [0.18, 0.78], [0.55, 0.80], [0.80, 0.76],
                [0.28, 0.14], [0.65, 0.20], [0.32, 0.44],
                [0.72, 0.46], [0.08, 0.68], [0.50, 0.68],
            ];

            const placed = [];

            function overlaps(x, y, w, h) {
                return placed.some(p =>
                    x < p.x + p.w + PAD &&
                    x + w + PAD > p.x &&
                    y < p.y + p.h + PAD &&
                    y + h + PAD > p.y
                );
            }

            els.forEach(el => {
                const EW = el.offsetWidth;
                const EH = el.offsetHeight;
                let fx = 0, fy = 0;

                for (const [nx, ny] of slots) {
                    const x = Math.min(nx * CW, CW - EW - 4);
                    const y = Math.min(ny * CH, CH - EH - 4);
                    if (!overlaps(x, y, EW, EH)) {
                        fx = x; fy = y;
                        break;
                    }
                }

                placed.push({ x: fx, y: fy, w: EW, h: EH });
                el.style.left       = fx + 'px';
                el.style.top        = fy + 'px';
                el.style.visibility = 'visible';
            });
        });
    })();

    gsap.utils.toArray('.ops-country').forEach((el, i) => {
        gsap.fromTo(el,
            { opacity: 0, scale: 0.7, x: (Math.random()-.5)*60, y: (Math.random()-.5)*40 },
            { opacity: 1, scale: 1, x: 0, y: 0, duration: 1.2, delay: i * 0.07,
              ease: 'elastic.out(1,0.6)',
              scrollTrigger: { trigger: '.ops-right', start: 'top 80%' } }
        );
        el.addEventListener('mouseenter', () => gsap.to(el, { scale: 1.08, color: 'var(--blue)', duration: 0.3 }));
        el.addEventListener('mouseleave', () => gsap.to(el, { scale: 1, color: '', duration: 0.4, ease: 'elastic.out(1,0.5)' }));
    });

    /* History */
    gsap.utils.toArray('.hs-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 },
            { opacity: 1, y: 0, duration: 0.9, delay: i * 0.1, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 85%' } }
        );
    });
    gsap.fromTo('.history-anim',
        { opacity: 0, y: 50, clipPath: 'inset(0 0 60% 0)' },
        { opacity: 1, y: 0, clipPath: 'inset(0 0 0% 0)', duration: 1.0, stagger: 0.18, ease: 'power3.out',
          scrollTrigger: { trigger: '.history-track', start: 'top 78%' } }
    );
    gsap.fromTo('.history-line', { scaleY: 0, transformOrigin: 'top' },
        { scaleY: 1, scrollTrigger: { trigger: '.history-section', start: 'top 60%', end: 'bottom 80%', scrub: 1 } }
    );
    document.querySelectorAll('.h-card').forEach(card => {
        card.addEventListener('mouseenter', () => gsap.to(card, { boxShadow: '0 8px 40px rgba(255,124,16,0.15)', duration: 0.3 }));
        card.addEventListener('mouseleave', () => gsap.to(card, { boxShadow: 'none', duration: 0.3 }));
    });

    /* Values */
    gsap.utils.toArray('.val-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 },
            { opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 85%' } }
        );
    });
    gsap.utils.toArray('.val-row-anim').forEach(row => {
        gsap.fromTo(row, { opacity: 0, x: -30 },
            { opacity: 1, x: 0, duration: 0.9, ease: 'power3.out',
              scrollTrigger: { trigger: row, start: 'top 88%' } }
        );
    });

    /* Section tags */
    gsap.utils.toArray('.section-tag').forEach(el => {
        gsap.fromTo(el, { opacity: 0, x: -16 },
            { opacity: 1, x: 0, duration: 0.7, ease: 'power3.out',
              scrollTrigger: { trigger: el, start: 'top 88%' } }
        );
    });

    /* Parallax breaks */
    document.querySelectorAll('[data-parallax]').forEach(el => {
        gsap.to(el, {
            yPercent: 22, ease: 'none',
            scrollTrigger: { trigger: el.closest('.parallax-break'), start: 'top bottom', end: 'bottom top', scrub: true }
        });
    });
</script>

</x-public-layout>
