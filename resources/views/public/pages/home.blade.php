<x-public-layout>

<style>
/* ══════════════════════════════════════
   SHARED SECTION ELEMENTS
══════════════════════════════════════ */
.reveal-char { display: inline-block; overflow: hidden; vertical-align: bottom; }
.reveal-char span { display: inline-block; transform: translateY(105%); }
.split-word  { display: inline-block; }

/* ══════════════════════════════════════
   IDENTITY SECTION
   White · typographic · left/right split
══════════════════════════════════════ */
.identity-section {
    padding: 110px 5% 0;
    background: var(--bg);
    position: relative; overflow: hidden;
}
.identity-inner {
    max-width: var(--container); margin: 0 auto;
    display: grid; grid-template-columns: 1fr 380px; gap: 80px;
    align-items: start; position: relative; z-index: 1;
}
.identity-eyebrow {
    font-family: var(--font-head); font-size: 10px;
    letter-spacing: 0.22em; color: var(--orange);
    text-transform: uppercase; display: flex; align-items: center;
    gap: 12px; margin-bottom: 28px;
}
.identity-eyebrow::before { content: ''; display: block; width: 32px; height: 1.5px; background: var(--orange); }
.identity-statement {
    font-family: var(--font-head);
    font-size: clamp(2.2rem, 4.2vw, 4rem);
    line-height: 1.08; letter-spacing: -0.035em;
    color: var(--text); font-weight: 700;
    margin-bottom: 28px;
}
.identity-statement em { font-style: normal; color: var(--blue); }
.identity-statement .or { color: var(--orange); }
.identity-body {
    font-size: 1.05rem; color: var(--text-muted); line-height: 1.85;
    max-width: 560px; margin-bottom: 36px;
}
.identity-cta {
    display: inline-flex; align-items: center; gap: 10px;
    color: var(--blue); font-family: var(--font-head); font-size: 11px;
    font-weight: 700; text-decoration: none; text-transform: uppercase;
    letter-spacing: 0.1em; padding-bottom: 4px;
    border-bottom: 1.5px solid rgba(34,119,187,0.3);
    transition: all 0.3s;
}
.identity-cta:hover { gap: 14px; border-color: var(--orange); color: var(--orange); }
.identity-right { padding-top: 8px; }
.identity-right-label {
    font-family: var(--font-head); font-size: 9px;
    letter-spacing: 0.2em; color: var(--text-light);
    text-transform: uppercase; margin-bottom: 18px; display: block;
}
.entity-line {
    display: grid; grid-template-columns: 6px 1fr;
    gap: 16px; padding: 18px 0;
    border-top: 1px solid var(--border);
    align-items: center;
}
.entity-line:last-child { border-bottom: 1px solid var(--border); }
.entity-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--orange); margin-top: 2px; align-self: start;
}
.entity-name {
    font-family: var(--font-head); font-size: 0.8rem;
    color: var(--text); font-weight: 700; line-height: 1.4;
}
.entity-sub { font-size: 0.78rem; color: var(--text-muted); margin-top: 3px; line-height: 1.4; }

/* Stats strip */
.identity-strip {
    margin-top: 80px; border-top: 1px solid var(--border);
    display: flex; max-width: calc(var(--container) + 10%); margin-left: auto; margin-right: auto;
}
.is-item {
    flex: 1; padding: 28px 36px;
    border-right: 1px solid var(--border);
    display: flex; flex-direction: column; gap: 6px;
}
.is-item:last-child { border-right: none; }
.is-num {
    font-family: var(--font-head); font-size: 2.4rem;
    font-weight: 700; color: var(--text); letter-spacing: -0.04em;
    line-height: 1;
}
.is-num span { color: var(--orange); font-size: 1.4rem; }
.is-lbl { font-size: 0.78rem; color: var(--text-muted); }


/* ══════════════════════════════════════
   IMAGE BREAK — full-bleed parallax
══════════════════════════════════════ */
.img-break {
    height: 60vh; min-height: 360px;
    position: relative; overflow: hidden;
    display: block;
}
.img-break-inner {
    position: absolute; inset: -15% 0;
    background-size: cover; background-position: center;
    will-change: transform;
}
.img-break-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(0deg, rgba(10,22,40,0.7) 0%, rgba(10,22,40,0.2) 50%, rgba(10,22,40,0.6) 100%);
    z-index: 1;
}
.img-break-caption {
    position: absolute; bottom: 40px; left: 5%; z-index: 2;
    color: rgba(255,255,255,0.6); font-family: var(--font-head);
    font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase;
}
.img-break-caption strong { color: #fff; display: block; font-size: 1.8rem; letter-spacing: -0.03em; margin-bottom: 6px; font-weight: 700; }


/* ══════════════════════════════════════
   GROWTH SECTION — dark, big numbers
══════════════════════════════════════ */
.growth-section {
    background: var(--bg-dark); padding: 110px 5%;
    position: relative; overflow: hidden;
}
.growth-section::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 85% 50%, rgba(34,119,187,0.14) 0%, transparent 60%);
    pointer-events: none;
}
.growth-header {
    max-width: var(--container); margin: 0 auto 70px;
    display: flex; justify-content: space-between; align-items: flex-end;
}
.growth-eyebrow {
    font-family: var(--font-head); font-size: 10px;
    letter-spacing: 0.22em; color: var(--orange);
    text-transform: uppercase; display: flex; align-items: center; gap: 12px; margin-bottom: 12px;
}
.growth-eyebrow::before { content: ''; display: block; width: 28px; height: 1.5px; background: var(--orange); }
.growth-title {
    font-family: var(--font-head); font-size: clamp(1.8rem, 3vw, 2.8rem);
    color: #fff; font-weight: 700; letter-spacing: -0.03em; line-height: 1.1;
}
.growth-subtitle {
    font-size: 0.95rem; color: rgba(255,255,255,0.4);
    max-width: 300px; text-align: right; line-height: 1.65;
}
.growth-rows {
    max-width: var(--container); margin: 0 auto;
    border-top: 1px solid rgba(255,255,255,0.07);
}
.growth-row {
    display: grid;
    grid-template-columns: 100px 1fr 220px 120px;
    align-items: center;
    padding: 38px 0;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    gap: 40px;
    position: relative;
}
.growth-row::before {
    content: ''; position: absolute; left: -5%; top: 0; bottom: 0; width: 0;
    background: linear-gradient(90deg, rgba(34,119,187,0.06), transparent);
    transition: width 0.5s ease; pointer-events: none;
}
.growth-row:hover::before { width: 110%; }
.gr-year {
    font-family: var(--font-head); font-size: 0.75rem;
    color: rgba(255,255,255,0.3); letter-spacing: 0.14em; text-transform: uppercase;
}
.gr-volume {
    font-family: var(--font-head);
    font-size: clamp(2.2rem, 5.5vw, 4.5rem);
    font-weight: 700; letter-spacing: -0.04em;
    color: #fff; line-height: 1;
}
.gr-volume .unit { font-size: 1rem; color: rgba(255,255,255,0.35); font-weight: 400; margin-left: 10px; letter-spacing: 0; }
.gr-bar-wrap { height: 2px; background: rgba(255,255,255,0.07); border-radius: 2px; overflow: hidden; }
.gr-bar-fill { height: 100%; background: linear-gradient(90deg, var(--blue), var(--orange)); border-radius: 2px; transform-origin: left; }
.gr-badge {
    font-family: var(--font-head); font-size: 0.7rem;
    color: var(--orange); letter-spacing: 0.1em; text-transform: uppercase; text-align: right;
}


/* (Markets section styles moved to style.css) */


/* ══════════════════════════════════════
   COMMODITIES — image cards strip
══════════════════════════════════════ */
.comm-list-section {
    background: var(--bg-dark); padding: 110px 0;
    overflow: hidden;
}
.comm-list-head {
    max-width: var(--container); margin: 0 auto 60px; padding: 0 5%;
}
.comm-list-head .section-title { color: #fff; }
.comm-list-head .section-tag { color: var(--orange); }

/* Horizontal scroll strip */
.comm-strip-wrap {
    overflow: hidden; position: relative;
    padding: 0 5%;
}
.comm-strip {
    display: flex; gap: 20px;
}
.comm-card {
    flex: 0 0 300px;
    height: 380px;
    border-radius: 16px; overflow: hidden;
    position: relative; cursor: default;
    border: 1px solid rgba(255,255,255,0.08);
    transition: transform 0.5s ease, box-shadow 0.5s ease;
}
.comm-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 30px 60px rgba(0,0,0,0.4); }
.comm-card-img {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    transition: transform 0.7s ease;
}
.comm-card:hover .comm-card-img { transform: scale(1.08); }
.comm-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(10,22,40,0.2) 0%, rgba(10,22,40,0.85) 100%);
}
.comm-card-body {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 28px 24px; z-index: 2;
}
.comm-card-num {
    font-family: var(--font-head); font-size: 11px;
    color: var(--orange); letter-spacing: 0.16em; text-transform: uppercase;
    margin-bottom: 8px; display: block;
}
.comm-card-name {
    font-family: var(--font-head); font-size: 1.25rem;
    color: #fff; font-weight: 700; line-height: 1.2;
    margin-bottom: 10px; letter-spacing: -0.02em;
}
.comm-card-desc { font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.6; }


/* ══════════════════════════════════════
   WHY PANASIA — alternating large-number
══════════════════════════════════════ */
.why-alt-section {
    background: var(--bg); padding: 110px 5%;
    overflow: hidden;
}
.why-alt-head {
    max-width: var(--container); margin: 0 auto 70px;
}
.why-alt-items { max-width: var(--container); margin: 0 auto; }
.why-alt-item {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: center;
    padding: 70px 0;
    border-top: 1px solid var(--border);
}
.why-alt-item:last-child { border-bottom: 1px solid var(--border); }
.why-alt-item.right { direction: rtl; }
.why-alt-item.right > * { direction: ltr; }
.wai-numblock { position: relative; }
.wai-bignumber {
    font-family: var(--font-head); font-size: 10rem;
    font-weight: 700; line-height: 0.85; letter-spacing: -0.08em;
    color: rgba(34,119,187,0.05); user-select: none; pointer-events: none;
    transition: color 0.5s;
}
.why-alt-item:hover .wai-bignumber { color: rgba(34,119,187,0.1); }
.wai-pill {
    position: absolute; top: 0; left: 0;
    background: var(--blue); color: #fff;
    font-family: var(--font-head); font-size: 9px;
    letter-spacing: 0.16em; text-transform: uppercase;
    padding: 6px 14px; border-radius: 20px;
}
.wai-img {
    margin-top: 20px; border-radius: 12px; overflow: hidden;
    height: 200px; position: relative;
}
.wai-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
.why-alt-item:hover .wai-img img { transform: scale(1.05); }
.wai-title {
    font-family: var(--font-head); font-size: clamp(1.5rem, 2.5vw, 2.1rem);
    color: var(--text); font-weight: 700; letter-spacing: -0.03em;
    margin-bottom: 18px; line-height: 1.1;
}
.wai-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.82; }
.wai-icon-row {
    display: flex; align-items: center; gap: 10px;
    margin-top: 22px; padding-top: 22px; border-top: 1px solid var(--border);
}
.wai-icon {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(34,119,187,0.08); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--blue);
    flex-shrink: 0;
}
.wai-icon-label { font-size: 0.85rem; color: var(--text-muted); }
.wai-icon-label strong { color: var(--text); font-weight: 600; display: block; font-size: 0.9rem; }


/* ══════════════════════════════════════
   CONTACT
══════════════════════════════════════ */
/* (Kept as-is from global styles) */


/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width: 1100px) {
    .identity-inner { grid-template-columns: 1fr; }
    .identity-right { display: none; }
    .growth-row { grid-template-columns: 80px 1fr; }
    .gr-bar-wrap, .gr-badge { display: none; }
    .why-alt-item { grid-template-columns: 1fr; gap: 20px; }
    .why-alt-item.right { direction: ltr; }
    .wai-bignumber { font-size: 7rem; }
    .comm-card { flex: 0 0 260px; height: 320px; }
}
@media (max-width: 768px) {
    .identity-section { padding: 80px 5% 0; }
    .growth-section { padding: 80px 5%; }
    .comm-list-section { padding: 80px 0; }
    .why-alt-section { padding: 80px 5%; }
    .why-alt-item { padding: 50px 0; gap: 40px; }
}
@media (max-width: 640px) {
    .identity-section { padding: 60px 5% 0; }
    .growth-section { padding: 60px 5%; }
    .comm-list-section { padding: 60px 0; }
    .why-alt-section { padding: 60px 5%; }
    .why-alt-item { padding: 36px 0; }
    .wai-bignumber { font-size: 6rem; }
    .identity-strip { flex-wrap: wrap; }
    .is-item { flex: 0 0 50%; }
    .growth-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    .growth-subtitle { text-align: left; }
    .comm-card { flex: 0 0 220px; height: 280px; }
}
</style>


<section class="identity-section">
    <div class="identity-inner">
        <div class="identity-left">
            <div class="identity-eyebrow id-anim">{{ _t($p['home_founded_eyebrow']->title ?? '') }}</div>
            <h2 class="identity-statement">
                @if(!empty($about_c) && $about_c->count())
                    <span class="split-animate">{!! _t($about_c->first()->title) !!}</span>
                @endif
            </h2>
            <p class="identity-body id-anim">
                @if(!empty($about_c) && $about_c->count())
                    {!! _t($about_c->first()->short_content) !!}
                @endif
            </p>
            <a href="/about" class="identity-cta id-anim">
                {{ _t($p['our_story']->title ?? '') }}
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="identity-right id-anim">
            <span class="identity-right-label">{{ _t($p['our_legal_entities']->title ?? '') }}</span>
            @if(!empty($home_entities) && $home_entities->count())
                @foreach($home_entities as $entity)
                <div class="entity-line">
                    <div class="entity-dot"></div>
                    <div>
                        <div class="entity-name">{{ _t($entity->title) }}</div>
                        @if(!empty(_t($entity->short_content ?? '')))
                            <div class="entity-sub">{!! _t($entity->short_content) !!}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="identity-strip">
        @if(!empty($home_stats) && $home_stats->count())
            @foreach($home_stats->take(4) as $stat)
                @php
                    $raw = $stat->options ?? '0';

                    $num = preg_replace('/[^0-9]/', '', $raw);

                    $suffix = trim(preg_replace('/[0-9,]/', '', $raw));
                @endphp

                <div class="is-item is-anim">
                    <div class="is-num">
                        <span class="count-num" data-target="{{ $num }}">0</span>
                        <span>{{ $suffix }}</span>
                    </div>
                    <div class="is-lbl">{{ _t($stat->title) }}</div>
                </div>
            @endforeach
        @endif
    </div>
</section>


{{-- ────────── PARALLAX IMAGE BREAK #1 ────────── --}}
<div class="img-break" id="imgBreak1">
    <div class="img-break-inner" id="imgBreak1Inner" style="background-image: url('{{ asset('assets/public/images/energy-infrastructure.webp') }}');"></div>
    <div class="img-break-overlay"></div>
    <div class="img-break-caption">
        <strong>{{ _t($p['img_energy_infra']->title ?? '') }}</strong>
        {{ _t($p['img_energy_infra_sub']->title ?? '') }}
    </div>
</div>


{{-- ────────── GROWTH SECTION ────────── --}}
<section class="growth-section">
    <div class="growth-header">
        <div>
            <div class="growth-eyebrow gs-anim">{{ _t($p['growth_eyebrow']->title ?? '') }}</div>
            <h2 class="growth-title gs-anim">{!! _t($p['growth_title']->title ?? '') !!}</h2>
        </div>
        <p class="growth-subtitle gs-anim">{{ _t($p['growth_subtitle']->title ?? '') }}</p>
    </div>
    <div class="growth-rows">
        @if(!empty($home_growth) && $home_growth->count())
            @foreach($home_growth as $i => $row)
            @php $pct = $loop->iteration == 1 ? 19 : ($loop->iteration == 2 ? 46 : ($loop->iteration == 3 ? 62 : 100)); @endphp
            <div class="growth-row gr-anim">
                <div class="gr-year">{{ _t($row->title) }}</div>
                <div class="gr-volume">{{ $row->options ?? '—' }}<span class="unit">MT</span></div>
                <div class="gr-bar-wrap"><div class="gr-bar-fill" style="width: 0%" data-w="{{ $pct }}"></div></div>
                <div class="gr-badge">{{ $row->short_content ? _t($row->short_content) : '' }}</div>
            </div>
            @endforeach
        @endif
    </div>
</section>


{{-- ────────── MARKETS — STICKY LEFT / SCROLL RIGHT ────────── --}}
<section class="markets-stick-section">

    {{-- LEFT: sticky panel --}}
    <div class="markets-stick-left">
        <span class="section-tag mr-head-anim">{{ _t($p['geographic_presence']->title ?? '') }}</span>
        <h2 class="section-title mr-head-anim">{!! _t($p['our_core_markets']->title ?? '') !!}</h2>
        <p class="msl-desc mr-head-anim">{{ _t($p['markets_desc']->title ?? '') }}</p>
        <div class="msl-tally mr-head-anim">
            <div class="msl-tally-item">
                <div class="msl-tally-num">{{ _t($p['markets_countries_num']->title ?? '11') }}</div>
                <div class="msl-tally-lbl">{{ _t($p['markets_countries_label']->title ?? '') }}</div>
            </div>
            <div class="msl-tally-item">
                <div class="msl-tally-num">{{ _t($p['markets_regions_num']->title ?? '4') }}</div>
                <div class="msl-tally-lbl">{{ _t($p['markets_regions_label']->title ?? '') }}</div>
            </div>
        </div>
    </div>

    <div class="markets-stick-right">
        @if(!empty($markets) && $markets->count())
            @foreach($markets as $market)
            @php $countries = array_filter(array_map('trim', explode(',', $market->options2 ?? ''))); @endphp
            <div class="msr-item">
                <div class="msr-num">0{{ $loop->iteration }}</div>
                <div class="msr-body">
                    <span class="msr-tag">{{ $market->options ?: 'Region 0' . $loop->iteration }}</span>
                    <h3 class="msr-name">{{ _t($market->title) }}</h3>
                    <p class="msr-desc">{!! _t($market->short_content ?? '') !!}</p>
                </div>
                <div class="msr-countries">
                    @foreach($countries as $country)<span class="msr-country">{{ $country }}</span>@endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>


{{-- ────────── PARALLAX IMAGE BREAK #2 ────────── --}}
<div class="img-break" id="imgBreak2">
    <div class="img-break-inner" id="imgBreak2Inner" style="background-image: url('{{ asset('assets/public/images/maritime-logistics.jpg') }}');"></div>
    <div class="img-break-overlay"></div>
    <div class="img-break-caption">
        <strong>{{ _t($p['img_maritime']->title ?? '') }}</strong>
        {!! _t($p['img_maritime_sub']->title ?? '') !!}
    </div>
</div>


{{-- ────────── COMMODITIES — IMAGE CARDS ────────── --}}
<section class="comm-list-section">
    <div class="comm-list-head">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:24px;">
            <div>
                <span class="section-tag cl-head-anim">{{ _t($p['what_we_trade']->title ?? '') }}</span>
                <h2 class="section-title cl-head-anim">{{ _t($p['trading_expertise']->title ?? '') }}</h2>
            </div>
            {{-- Carousel nav --}}
            <div class="comm-carousel-nav cl-head-anim">
                <button class="comm-carousel-btn" id="commPrev" aria-label="Previous" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="comm-carousel-btn" id="commNext" aria-label="Next">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="comm-strip-wrap">
        <div class="comm-strip" id="commStrip">
            @if(!empty($commodities) && $commodities->count())
                @foreach($commodities as $commodity)
                <div class="comm-card cl-anim">
                    <div class="comm-card-img" style="background-image: url('{{ url_u() . 'commodities/' . getImgMain($commodity) }}');"></div>
                    <div class="comm-card-overlay"></div>
                    <div class="comm-card-body">
                        <span class="comm-card-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="comm-card-name">{{ _t($commodity->title) }}</div>
                        <div class="comm-card-desc">{!! _t($commodity->short_content ?? '') !!}</div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- ────────── WHY PANASIA — ALTERNATING ────────── --}}
<section class="why-alt-section">
    <div class="why-alt-head">
        <span class="section-tag wh-head-anim">{{ _t($p['our_competitive_edge']->title ?? '') }}</span>
        <h2 class="section-title wh-head-anim">{{ _t($p['why_panasia_group']->title ?? '') }}</h2>
        <p class="section-subtitle wh-head-anim" style="max-width: 480px;">{{ _t($p['why_panasia_subtitle']->title ?? '') }}</p>
    </div>
    <div class="why-alt-items">
        @if(!empty($why_cards) && $why_cards->count())
            @foreach($why_cards as $card)
            <div class="why-alt-item {{ $loop->even ? 'right' : '' }} wai-anim">
                <div class="wai-numblock">
                    <span class="wai-pill">0{{ $loop->iteration }}</span>
                    <div class="wai-bignumber">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="wai-img"><img src="{{ url_u() . 'why_cards/' . getImgMain($card) }}" alt="{{ _t($card->title) }}" loading="lazy"></div>
                </div>
                <div class="wai-body">
                    <h3 class="wai-title">{{ _t($card->title) }}</h3>
                    <p class="wai-desc">{!! _t($card->short_content ?? '') !!}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>


{{-- ────────── CONTACT ────────── --}}
<section class="contact-section">
    <div class="contact-container">
        <div class="contact-info">
            <h2 class="contact-title">
                {{ _t($p['contact_title_line1']->title ?? '') }}<br>
                <span class="text-outline">{{ _t($p['contact_title_line2']->title ?? '') }}</span><br>
                {{ _t($p['contact_title_line3']->title ?? '') }}
            </h2>
            <p class="contact-desc">{{ _t($p['contact_desc']->title ?? '') }}</p>
            <div class="contact-details">
                <div class="cd-item">
                    <span class="cd-label">{{ _t($p['contact_email_label']->title ?? '') }}</span>
                    <a href="mailto:{{ _t($p['contact_email_value']->title ?? '') }}" class="cd-link">{{ _t($p['contact_email_value']->title ?? '') }}</a>
                </div>
                <div class="cd-item">
                    <span class="cd-label">{{ _t($p['contact_phone_label']->title ?? '') }}</span>
                    <a href="tel:{{ preg_replace('/\s/', '', _t($p['contact_phone_value']->title ?? '')) }}" class="cd-link">{{ _t($p['contact_phone_value']->title ?? '') }}</a>
                </div>
                <div class="cd-item">
                    <span class="cd-label">{{ _t($p['contact_hq_label']->title ?? '') }}</span>
                    <a href="#" class="cd-link">{{ _t($p['contact_hq_value']->title ?? '') }}</a>
                </div>
            </div>
        </div>
        <div class="contact-form-wrapper">
            @if(session('form_success'))
                <div class="cform-success" style="text-align:center;padding:48px 24px;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity:.7;display:block;margin:0 auto 16px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <p style="opacity:.8;">{{ _t($p['form_success_msg']->title ?? 'Your message has been sent. We will get back to you shortly.') }}</p>
                </div>
            @else
            <form class="contact-form" action="{{ route('form.contact') }}" method="POST">
                @csrf
                @if($errors->has('captcha_code'))
                    <div class="cform-error" style="background:rgba(220,50,50,.12);border:1px solid rgba(220,50,50,.3);border-radius:6px;padding:10px 14px;margin-bottom:16px;font-size:.9rem;color:#ff6b6b;">{{ $errors->first('captcha_code') }}</div>
                @endif
                <div class="form-group">
                    <input type="text" id="h_name" name="fio" class="form-input" placeholder=" " value="{{ old('fio') }}" required>
                    <label for="h_name" class="form-label">{{ _t($p['form_your_name']->title ?? '') }}</label>
                    <div class="input-border"></div>
                </div>
                <div class="form-group">
                    <input type="email" id="h_email" name="email" class="form-input" placeholder=" " value="{{ old('email') }}" required>
                    <label for="h_email" class="form-label">{{ _t($p['form_email_address']->title ?? '') }}</label>
                    <div class="input-border"></div>
                </div>
                <!-- <div class="form-group">
                    <input type="text" id="h_company" name="address" class="form-input" placeholder=" " value="{{ old('address') }}">
                    <label for="h_company" class="form-label">{{ _t($p['form_company_optional']->title ?? '') }}</label>
                    <div class="input-border"></div>
                </div> -->
                <div class="form-group">
                    <input type="tel" id="h_phone" name="phone" class="form-input" placeholder=" " value="{{ old('phone') }}" required>
                    <label for="h_phone" class="form-label">{{ _t($p['form_phone_optional']->title ?? 'Phone (optional)') }}</label>
                    <div class="input-border"></div>
                </div>
                <div class="form-group">
                    <textarea id="h_message" name="message" class="form-input form-textarea" placeholder=" " rows="1">{{ old('message') }}</textarea>
                    <label for="h_message" class="form-label">{{ _t($p['form_how_can_we_help']->title ?? '') }}</label>
                    <div class="input-border"></div>
                </div>
                <div style="display:flex;gap:16px;align-items:flex-end;margin-bottom:4px;">
                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                        <img id="h-captcha-img" src="{{ route('captcha') }}" alt="captcha" style="height:48px;border-radius:6px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.05);">
                        <button type="button" onclick="refreshHomeCaptcha()" title="Refresh" style="background:none;border:none;cursor:pointer;color:inherit;opacity:.6;padding:4px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        </button>
                    </div>
                    <div class="form-group" style="flex:1;margin-bottom:0;">
                        <input type="text" id="h_captcha" name="captcha_code" class="form-input" placeholder="Enter CAPTCHA " autocomplete="off" required>
                        <label for="h_captcha" class="form-label">{{ _t($p['form_captcha_label']->title ?? 'Enter code above') }}</label>
                        <div class="input-border"></div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <span>{{ _t($p['send_message']->title ?? '') }}</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>
            @endif
        </div>
    </div>
</section>


<script>
gsap.registerPlugin(ScrollTrigger);

/* ══════════════════════════════════════
   UTILITY: split text into line-spans (optimized)
══════════════════════════════════════ */
function splitLines(el) {
    const html = el.innerHTML;
    const lines = html.split('<br>');
    el.innerHTML = lines.map(l =>
        `<span class="reveal-line" style="display:block;overflow:hidden;"><span class="reveal-inner" style="display:block;">${l}</span></span>`
    ).join('');
    return el.querySelectorAll('.reveal-inner');
}

/* ─── Identity section animated headline ── */
const stmtEl = document.querySelector('.identity-statement .split-animate');
if (stmtEl) {
    const inners = splitLines(stmtEl);
    gsap.set(inners, { y: '105%' });
    ScrollTrigger.create({
        trigger: stmtEl, start: 'top 85%',
        onEnter: () => gsap.to(inners, { y: '0%', stagger: 0.1, duration: 0.9, ease: 'power3.out' })
    });
}

/* ─── Identity section generic fade-ins (optimized) ── */
gsap.utils.toArray('.id-anim').forEach((el, i) => {
    gsap.set(el, { opacity: 0, y: 24 });
    ScrollTrigger.create({
        trigger: el, start: 'top 88%',
        onEnter: () => gsap.to(el, { opacity: 1, y: 0, duration: 0.8, delay: i * 0.08, ease: 'power2.out' })
    });
});

/* ─── Stats strip (count-up on enter, once only) ── */
gsap.utils.toArray('.is-anim').forEach((el, i) => {
    gsap.set(el, { opacity: 0, y: 20 });
    ScrollTrigger.create({
        trigger: el, start: 'top 90%', once: true,
        onEnter: () => {
            gsap.to(el, { opacity: 1, y: 0, duration: 0.7, delay: i * 0.08, ease: 'power2.out' });
            const numEl = el.querySelector('.count-num');
            if (numEl && !numEl.dataset.counted) {
                numEl.dataset.counted = '1';
                const target = parseInt(numEl.dataset.target || 0);
                gsap.to({ val: 0 }, {
                    val: target, duration: 1.8, ease: 'power2.out', delay: i * 0.08,
                    onUpdate: function() { numEl.textContent = Math.floor(this.targets()[0].val).toLocaleString(); }
                });
            }
        }
    });
});

/* ─── Parallax image breaks (optimized) ── */
['imgBreak1Inner', 'imgBreak2Inner'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    gsap.to(el, {
        yPercent: 18, ease: 'none',
        scrollTrigger: { trigger: el.parentElement, start: 'top bottom', end: 'bottom top', scrub: 0.8 }
    });
});

/* ─── Growth section animations (lightweight) ── */
gsap.utils.toArray('.gs-anim').forEach((el, i) => {
    gsap.set(el, { opacity: 0, y: 20 });
    ScrollTrigger.create({
        trigger: el, start: 'top 88%',
        onEnter: () => gsap.to(el, { opacity: 1, y: 0, duration: 0.7, delay: i * 0.1, ease: 'power2.out' })
    });
});
gsap.utils.toArray('.gr-anim').forEach((row, i) => {
    gsap.set(row, { opacity: 0, x: -30 });
    const bar = row.querySelector('.gr-bar-fill');
    const targetW = bar ? bar.dataset.w : 0;
    ScrollTrigger.create({
        trigger: row, start: 'top 90%',
        onEnter: () => {
            gsap.to(row, { opacity: 1, x: 0, duration: 0.8, delay: i * 0.12, ease: 'power2.out' });
            if (bar) gsap.to(bar, { width: targetW + '%', duration: 1.2, delay: i * 0.12 + 0.3, ease: 'power2.out' });
        }
    });
});

/* ─── Section headers fade-in ── */
['mr-head-anim','cl-head-anim','wh-head-anim'].forEach(cls => {
    gsap.utils.toArray('.' + cls).forEach((el, i) => {
        gsap.set(el, { opacity: 0, y: 18 });
        ScrollTrigger.create({
            trigger: el, start: 'top 88%',
            onEnter: () => gsap.to(el, { opacity: 1, y: 0, duration: 0.7, delay: i * 0.08, ease: 'power2.out' })
        });
    });
});

/* ─── Sticky markets left panel entrance ── */
gsap.set('.markets-stick-left .section-tag, .markets-stick-left .section-title, .msl-desc, .msl-tally', { opacity: 0, x: -24 });
ScrollTrigger.create({
    trigger: '.markets-stick-section', start: 'top 78%',
    onEnter: () => gsap.to('.markets-stick-left .section-tag, .markets-stick-left .section-title, .msl-desc, .msl-tally', {
        opacity: 1, x: 0, stagger: 0.08, duration: 0.8, ease: 'power2.out'
    })
});

/* ─── Sticky markets: items visible by default (CSS handles opacity) ── */
/* No GSAP animation needed - CSS has opacity: 1 !important */

/* ─── Commodity cards: stagger scale-in (optimized) ── */
gsap.utils.toArray('.cl-anim').forEach((card, i) => {
    gsap.set(card, { opacity: 0, y: 40, scale: 0.96 });
    ScrollTrigger.create({
        trigger: card, start: 'top 92%',
        onEnter: () => gsap.to(card, { opacity: 1, y: 0, scale: 1, duration: 0.7, delay: i * 0.04, ease: 'back.out(1.3)' })
    });
});

/* ─── Commodity carousel ── */
(function() {
    const strip    = document.getElementById('commStrip');
    const prevBtn  = document.getElementById('commPrev');
    const nextBtn  = document.getElementById('commNext');
    const countEl  = document.getElementById('commCount');
    if (!strip || !prevBtn || !nextBtn) return;

    const cards    = strip.querySelectorAll('.comm-card');
    const total    = cards.length;
    let current    = 0;

    function getVisible() {
        const w = strip.parentElement.offsetWidth;
        if (w < 600) return 1;
        if (w < 900) return 2;
        return 3;
    }

    function update() {
        const visible  = getVisible();
        const maxIndex = Math.max(0, total - visible);
        current        = Math.min(current, maxIndex);
        const cardW    = cards[0].offsetWidth + 20; // card + gap
        strip.style.transform = `translateX(-${current * cardW}px)`;
        prevBtn.disabled = current === 0;
        nextBtn.disabled = current >= maxIndex;
        if (countEl) countEl.textContent = `${current + 1} / ${maxIndex + 1}`;
    }

    prevBtn.addEventListener('click', () => { current = Math.max(0, current - 1); update(); });
    nextBtn.addEventListener('click', () => { current = Math.min(total - getVisible(), current + 1); update(); });
    window.addEventListener('resize', update);
    update();
})();

/* ─── Why items: clip-path reveal (optimized) ── */
gsap.utils.toArray('.wai-anim').forEach((item, i) => {
    gsap.set(item, { opacity: 0, clipPath: 'inset(0 0 100% 0)' });
    ScrollTrigger.create({
        trigger: item, start: 'top 85%',
        onEnter: () => gsap.to(item, { opacity: 1, clipPath: 'inset(0 0 0% 0)', duration: 0.9, ease: 'power3.out' })
    });
});


/* ─── Contact section (optimized) ── */
gsap.set(['.contact-title','.contact-desc','.contact-details','.contact-form-wrapper'], { opacity: 0, y: 24 });
ScrollTrigger.create({
    trigger: '.contact-section', start: 'top 78%',
    onEnter: () => {
        gsap.to('.contact-title',        { opacity: 1, y: 0, duration: 0.8,   ease: 'power2.out' });
        gsap.to('.contact-desc',         { opacity: 1, y: 0, duration: 0.8,   ease: 'power2.out', delay: 0.1 });
        gsap.to('.contact-details',      { opacity: 1, y: 0, duration: 0.8,   ease: 'power2.out', delay: 0.18 });
        gsap.to('.contact-form-wrapper', { opacity: 1, y: 0, duration: 0.9,   ease: 'power2.out', delay: 0.15 });
    }
});

/* ─── Home captcha refresh ── */
        function refreshHomeCaptcha() {
            const img = document.getElementById('h-captcha-img');
            if (img) img.src = '{{ route('captcha') }}?t=' + Date.now();
        }

        /* ─── Marquee hover pause ── */
document.querySelectorAll('.marquee-content').forEach(el => {
    el.addEventListener('mouseenter', () => el.style.animationPlayState = 'paused');
    el.addEventListener('mouseleave', () => el.style.animationPlayState = 'running');
});

/* ─── Section heading split-text on scroll (lightweight) ── */
document.querySelectorAll('.section-title').forEach(el => {
    const lines = splitLines(el);
    gsap.set(lines, { y: '105%' });
    ScrollTrigger.create({
        trigger: el, start: 'top 90%',
        onEnter: () => gsap.to(lines, { y: '0%', stagger: 0.06, duration: 0.8, ease: 'power3.out' })
    });
});
</script>

</x-public-layout>
