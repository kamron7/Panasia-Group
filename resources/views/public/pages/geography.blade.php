<x-public-layout>

    <style>
        /* ── HERO ── */
        .geo-hero {
            min-height: 60vh; padding: 0;
            background: var(--bg-dark);
            position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
        }
        .geo-hero::before {
            content: 'MAP';
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-family: var(--font-head); font-size: 40vw; font-weight: 700;
            color: rgba(255,255,255,0.02); white-space: nowrap; pointer-events: none;
            letter-spacing: -0.02em; z-index: 0;
        }
        .geo-hero-inner {
            max-width: var(--container); margin: 0 auto;
            position: relative; z-index: 1;
            padding: 160px 5% 80px;
        }
        .geo-eyebrow {
            font-family: var(--font-head); font-size: 10px;
            letter-spacing: 0.22em; color: var(--orange);
            margin-bottom: 22px; display: block; text-transform: uppercase;
        }
        .geo-title {
            font-family: var(--font-head);
            font-size: clamp(3rem, 7vw, 6.5rem);
            line-height: 0.92; color: #fff; letter-spacing: -0.03em;
            font-weight: 700; text-transform: uppercase; margin-bottom: 28px;
        }
        .geo-title .t-blue { color: var(--blue); }
        .geo-hero-desc {
            font-size: 1.05rem; color: rgba(255,255,255,0.6); line-height: 1.8;
            max-width: 600px;
        }

        /* ── MAP SECTION ── */
        .geo-map-section {
            background: var(--bg); padding: 10px 5% 100px;
        }
        .geo-map-inner { max-width: 1200px; margin: 0 auto; }

        /* Legend */
        .geo-legend {
            display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 48px;
        }
        .geo-legend-item {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 50px;
            border: 1px solid var(--border); background: var(--bg-alt);
            cursor: pointer; transition: all 0.25s;
            font-family: var(--font-head); font-size: 11px; font-weight: 600;
            color: var(--text-muted); letter-spacing: 0.04em;
        }
        .geo-legend-item:hover,
        .geo-legend-item.active {
            border-color: var(--blue); color: var(--text);
            background: rgba(34,119,187,0.08);
        }
        .geo-legend-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--blue); flex-shrink: 0;
            transition: background 0.25s;
        }
        .geo-legend-item.active .geo-legend-dot { background: var(--orange); }

        /* Map wrapper */
        .geo-map-wrap {
            background: #07111e;
            border-radius: 20px;
            border: 1px solid var(--border);
            overflow: hidden;
            position: relative;
            min-height: 400px;
        }
        .geo-map-wrap svg { display: block; width: 100%; height: auto; }

        /* World background */
        .geo-path-world {
            fill: #0c1e30;
            stroke: rgba(255,255,255,0.08);
            stroke-width: 0.5;
            pointer-events: none;
        }

        /* Highlighted countries */
        .geo-path-highlight {
            fill: rgba(34, 119, 187, 0.18);
            stroke: rgba(34, 119, 187, 0.82);
            stroke-width: 1.5;
            cursor: pointer;
            transition: fill 0.22s ease, stroke 0.22s ease, stroke-width 0.22s ease;
            filter: drop-shadow(0 0 4px rgba(34,119,187,0.5));
        }
        .geo-path-highlight:hover {
            fill: rgba(34, 119, 187, 0.40);
            stroke: rgba(80, 170, 255, 1);
            stroke-width: 2;
        }
        .geo-path-highlight.active {
            fill: rgba(34, 119, 187, 0.55);
            stroke: #90d0ff;
            stroke-width: 2;
        }

        /* Corridor lines – animated flow */
        .geo-corridor {
            fill: none;
            stroke: rgba(34, 119, 187, 0.50);
            stroke-width: 1.3;
            stroke-dasharray: 6 5;
            stroke-linecap: round;
            pointer-events: none;
            animation: geo-flow 2.8s linear infinite;
        }
        @keyframes geo-flow {
            from { stroke-dashoffset: 0; }
            to   { stroke-dashoffset: -44; }
        }

        /* Dots */
        .geo-dot-halo {
            fill: none;
            stroke: rgba(255, 124, 16, 0.55);
            stroke-width: 1.5;
            pointer-events: none;
            transform-box: fill-box;
            transform-origin: center;
            animation: geo-halo-out 2.3s ease-out infinite;
        }
        @keyframes geo-halo-out {
            0%   { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(3.2); opacity: 0; }
        }
        .geo-dot-core {
            fill: #FF7C10;
            pointer-events: none;
            filter: drop-shadow(0 0 4px rgba(255,124,16,0.9));
        }

        /* Labels */
        .geo-label {
            font-family: var(--font-head, sans-serif);
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            fill: rgba(255,255,255,0.60);
            pointer-events: none;
            user-select: none;
        }

        /* Loading */
        .geo-map-loading {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.22);
            font-family: var(--font-head); font-size: 11px; letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        /* Tooltip */
        .geo-tooltip {
            position: absolute; pointer-events: none; z-index: 20;
            background: rgba(7, 17, 30, 0.97);
            border: 1px solid rgba(34,119,187,0.45);
            border-radius: 10px; padding: 10px 18px;
            opacity: 0; transform: translateY(6px);
            transition: opacity 0.18s, transform 0.18s;
            white-space: nowrap;
        }
        .geo-tooltip.visible { opacity: 1; transform: translateY(0); }
        .gt-name {
            font-family: var(--font-head); font-size: 0.9rem;
            color: #fff; font-weight: 700; display: block; margin-bottom: 3px;
        }
        .gt-region { font-size: 0.75rem; color: rgba(255,255,255,0.42); }

        /* ── COUNTRY GRID ── */
        .geo-countries { background: var(--bg-alt); padding: 80px 5%; }
        .geo-countries-inner { max-width: var(--container); margin: 0 auto; }
        .geo-countries-head { margin-bottom: 48px; }
        .geo-country-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .gcc-item {
            border: 1px solid var(--border); border-radius: 12px;
            padding: 24px 20px; background: var(--bg); transition: all 0.3s;
        }
        .gcc-item:hover {
            border-color: rgba(34,119,187,0.3);
            box-shadow: 0 8px 24px rgba(34,119,187,0.07);
            transform: translateY(-2px);
        }
        .gcc-region {
            font-family: var(--font-head); font-size: 8px;
            letter-spacing: 0.18em; color: var(--orange);
            text-transform: uppercase; margin-bottom: 8px; display: block;
        }
        .gcc-name {
            font-family: var(--font-head); font-size: 0.95rem;
            color: var(--text); font-weight: 700; letter-spacing: -0.01em;
        }
        .gcc-city { font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; }

        /* ── FOOTPRINT ── */
        .geo-footprint { background: var(--bg-dark); padding: 100px 5%; }
        .geo-footprint-inner {
            max-width: var(--container); margin: 0 auto;
            display: grid; grid-template-columns: 1fr 480px; gap: 80px; align-items: center;
        }
        .gf-tag {
            font-family: var(--font-head); font-size: 10px;
            letter-spacing: 0.2em; color: var(--orange);
            text-transform: uppercase; margin-bottom: 20px; display: block;
        }
        .gf-title {
            font-family: var(--font-head); font-size: clamp(2rem, 3.5vw, 3rem);
            color: #fff; font-weight: 700; letter-spacing: -0.03em;
            line-height: 1.1; margin-bottom: 24px;
        }
        .gf-body { font-size: 1rem; color: rgba(255,255,255,0.55); line-height: 1.85; }
        .gf-stats { display: flex; flex-direction: column; gap: 0; }
        .gf-stat {
            padding: 28px 0; border-bottom: 1px solid rgba(255,255,255,0.07);
            display: grid; grid-template-columns: 80px 1fr; gap: 20px; align-items: center;
        }
        .gf-stat:first-child { border-top: 1px solid rgba(255,255,255,0.07); }
        .gfs-num {
            font-family: var(--font-head); font-size: 2.4rem;
            font-weight: 700; color: #fff; letter-spacing: -0.04em; line-height: 1;
        }
        .gfs-num span { color: var(--orange); font-size: 1.3rem; }
        .gfs-lbl { font-size: 0.875rem; color: rgba(255,255,255,0.45); line-height: 1.5; }

        @media (max-width: 1024px) {
            .geo-footprint-inner { grid-template-columns: 1fr; }
            .geo-country-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 640px) {
            .geo-country-grid { grid-template-columns: repeat(2, 1fr); }
            .geo-legend { display: none; }
        }
        @media (max-width: 600px) {
            .geo-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/topojson/3.0.2/topojson.min.js"></script>


    {{-- HERO --}}
    <section class="geo-hero">
        <div class="geo-hero-inner">
            <span class="geo-eyebrow geo-anim">{{ _t($p['geo_hero_eyebrow']->title ?? 'Global Footprint') }}</span>
            <h1 class="geo-title geo-anim">
                {{ _t($p['geo_hero_title1']->title ?? 'Our') }}<br><span class="t-blue">{{ _t($p['geo_hero_title2']->title ?? 'Geography.') }}</span>
            </h1>
            <p class="geo-hero-desc geo-anim">
                {{ _t($p['geo_hero_desc']->title ?? '') }}
            </p>
        </div>
    </section>


    {{-- MAP + LEGEND --}}
    <section class="geo-map-section">
        <div class="geo-map-inner">

            <div class="geo-legend">
                @php
                    $mapCountries = [
                        ['id' => 'uae',          'name' => 'UAE',          'region' => 'Middle East'],
                        ['id' => 'switzerland',  'name' => 'Switzerland',  'region' => 'Europe'],
                        ['id' => 'romania',      'name' => 'Romania',      'region' => 'Europe'],
                        ['id' => 'greece',       'name' => 'Greece',       'region' => 'Europe'],
                        ['id' => 'turkey',       'name' => 'Turkey',       'region' => 'Eurasia'],
                        ['id' => 'georgia',      'name' => 'Georgia',      'region' => 'Caucasus'],
                        ['id' => 'azerbaijan',   'name' => 'Azerbaijan',   'region' => 'Caucasus'],
                        ['id' => 'turkmenistan', 'name' => 'Turkmenistan', 'region' => 'Central Asia'],
                        ['id' => 'uzbekistan',   'name' => 'Uzbekistan',   'region' => 'Central Asia'],
                        ['id' => 'kyrgyzstan',   'name' => 'Kyrgyzstan',   'region' => 'Central Asia'],
                        ['id' => 'kazakhstan',   'name' => 'Kazakhstan',   'region' => 'Central Asia'],
                    ];
                @endphp
{{--                @foreach($mapCountries as $c)--}}
{{--                    <div class="geo-legend-item" data-country="{{ $c['id'] }}">--}}
{{--                        <div class="geo-legend-dot"></div>--}}
{{--                        {{ $c['name'] }}--}}
{{--                    </div>--}}
{{--                @endforeach--}}
            </div>

            <div class="geo-map-wrap" id="geoMapWrap">
                <div class="geo-map-loading" id="geoMapLoading">{{ _t($p['geo_map_loading']->title ?? 'Loading map…') }}</div>
                <div class="geo-tooltip" id="geoTooltip">
                    <span class="gt-name"   id="geoTooltipName"></span>
                    <span class="gt-region" id="geoTooltipRegion"></span>
                </div>
            </div>

        </div>
    </section>


    {{-- COUNTRY GRID --}}
    <section class="geo-countries">
        <div class="geo-countries-inner">
            <div class="geo-countries-head">
                <span class="section-tag geo-head-anim">{{ _t($p['geo_grid_tag']->title ?? 'Our Presence') }}</span>
                <h2 class="section-title geo-head-anim">{{ _t($p['geo_grid_title']->title ?? '11 Countries') }}</h2>
            </div>
            <div class="geo-country-grid">
                @foreach($geo_countries as $country)
                    <div class="gcc-item geo-card-anim">
                        <span class="gcc-region">{{ _t($country->short_content) }}</span>
                        <div class="gcc-name">{{ _t($country->title) }}</div>
                        <div class="gcc-city">{{ $country->options }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- FOOTPRINT --}}
    <!-- <section class="geo-footprint">
        <div class="geo-footprint-inner">
            <div>
                <span class="gf-tag geo-anim2">{{ _t($p['geo_fp_tag']->title ?? 'Geographic Coverage') }}</span>
                <h2 class="gf-title geo-anim2">{!! _t($p['geo_fp_title']->title ?? 'Spanning Europe,<br>Caucasus &amp;<br>Central Asia') !!}</h2>
                <p class="gf-body geo-anim2">
                    {{ _t($p['geo_fp_body']->title ?? '') }}
                </p>
            </div>
            <div class="gf-stats">
                <div class="gf-stat geo-anim2">
                    <div class="gfs-num">{{ _t($p['geo_fp_stat1_num']->title ?? '11') }}</div>
                    <div class="gfs-lbl">{{ _t($p['geo_fp_stat1_lbl']->title ?? 'Countries in our operational network') }}</div>
                </div>
                <div class="gf-stat geo-anim2">
                    <div class="gfs-num">{{ _t($p['geo_fp_stat2_num']->title ?? '4') }}</div>
                    <div class="gfs-lbl">{{ _t($p['geo_fp_stat2_lbl']->title ?? 'Geographic regions covered') }}</div>
                </div>
                <div class="gf-stat geo-anim2">
                    <div class="gfs-num">{!! _t($p['geo_fp_stat3_num']->title ?? '3<span>+</span>') !!}</div>
                    <div class="gfs-lbl">{{ _t($p['geo_fp_stat3_lbl']->title ?? 'Key logistics corridors') }}</div>
                </div>
            </div>
        </div>
    </section> -->


    <script>
        /* ═══════════════════════════════
           GSAP
        ═══════════════════════════════ */
        gsap.registerPlugin(ScrollTrigger);

        gsap.fromTo('.geo-anim', { y: 40, opacity: 0 }, {
            y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
        });

        gsap.utils.toArray('.geo-head-anim').forEach((el, i) => {
            gsap.fromTo(el, { opacity: 0, y: 20 }, {
                opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 88%' }
            });
        });

        gsap.utils.toArray('.geo-card-anim').forEach((el, i) => {
            gsap.fromTo(el, { opacity: 0, y: 20 }, {
                opacity: 1, y: 0, duration: 0.65, delay: (i % 4) * 0.08, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 90%' }
            });
        });

        gsap.utils.toArray('.geo-anim2').forEach((el, i) => {
            gsap.fromTo(el, { opacity: 0, y: 28 }, {
                opacity: 1, y: 0, duration: 0.9, delay: i * 0.12, ease: 'power3.out',
                scrollTrigger: { trigger: el, start: 'top 85%' }
            });
        });


        /* ═══════════════════════════════
           D3 MAP
        ═══════════════════════════════ */
        (function () {

            /*
             * Country registry
             * id  = ISO 3166-1 numeric (what world-atlas stores as d.id)
             * capital = [longitude, latitude] of the capital / main city
             */
            const COUNTRIES = {
                '784': { slug: 'uae',          name: 'UAE',          region: 'Middle East',  capital: [54.37,  24.47] },
                '756': { slug: 'switzerland',  name: 'Switzerland',  region: 'Europe',       capital: [7.45,   46.95] },
                '642': { slug: 'romania',      name: 'Romania',      region: 'Europe',       capital: [26.10,  44.44] },
                '300': { slug: 'greece',       name: 'Greece',       region: 'Europe',       capital: [23.73,  37.98] },
                '792': { slug: 'turkey',       name: 'Turkey',       region: 'Eurasia',      capital: [32.86,  39.93] },
                '268': { slug: 'georgia',      name: 'Georgia',      region: 'Caucasus',     capital: [44.83,  41.69] },
                '31':  { slug: 'azerbaijan',   name: 'Azerbaijan',   region: 'Caucasus',     capital: [49.87,  40.41] },
                '795': { slug: 'turkmenistan', name: 'Turkmenistan', region: 'Central Asia', capital: [58.38,  37.95] },
                '860': { slug: 'uzbekistan',   name: 'Uzbekistan',   region: 'Central Asia', capital: [69.29,  41.30] },
                '417': { slug: 'kyrgyzstan',   name: 'Kyrgyzstan',   region: 'Central Asia', capital: [74.59,  42.87] },
                '398': { slug: 'kazakhstan',   name: 'Kazakhstan',   region: 'Central Asia', capital: [71.45,  51.18] },
            };

            const SLUG_TO_ID = Object.fromEntries(
                Object.entries(COUNTRIES).map(([id, v]) => [v.slug, id])
            );

            /* DOM */
            const wrap        = document.getElementById('geoMapWrap');
            const loadingEl   = document.getElementById('geoMapLoading');
            const tooltip     = document.getElementById('geoTooltip');
            const tipName     = document.getElementById('geoTooltipName');
            const tipRegion   = document.getElementById('geoTooltipRegion');
            const legendItems = document.querySelectorAll('.geo-legend-item');

            /* Canvas dimensions */
            const W = Math.max(wrap.offsetWidth || 900, 480);
            const H = Math.round(W * 0.56);

            /* SVG element */
            const svg = d3.select('#geoMapWrap')
                .insert('svg', '.geo-tooltip')
                .attr('viewBox', `0 0 ${W} ${H}`)
                .attr('width', W)
                .attr('height', H)
                .style('display', 'block')
                .style('width', '100%')
                .style('height', 'auto');

            /* Ocean fill */
            svg.append('rect').attr('width', W).attr('height', H).attr('fill', '#07111e');

            /* Subtle grid */
            const gridG = svg.append('g')
                .attr('stroke', 'rgba(255,255,255,0.03)')
                .attr('stroke-width', 0.6);
            [0.2, 0.4, 0.6, 0.8].forEach(f => {
                gridG.append('line').attr('x1', W*f).attr('y1', 0).attr('x2', W*f).attr('y2', H);
                gridG.append('line').attr('x1', 0).attr('y1', H*f).attr('x2', W).attr('y2', H*f);
            });

            /* Projection — scale(1) prevents stray rendering before fitExtent */
            const projection = d3.geoMercator().scale(1).translate([0, 0]);
            const pathGen    = d3.geoPath().projection(projection);

            /* State */
            let activeId = null;

            /* Tooltip */
            function showTip(name, region, cx, cy) {
                tipName.textContent   = name;
                tipRegion.textContent = region;
                moveTip(cx, cy);
                tooltip.classList.add('visible');
            }
            function moveTip(cx, cy) {
                const r = wrap.getBoundingClientRect();
                let tx = cx - r.left + 14;
                let ty = cy - r.top  - 52;
                if (tx + 180 > W) tx = cx - r.left - 190;
                if (ty < 8)       ty = cy - r.top  + 18;
                tooltip.style.left = tx + 'px';
                tooltip.style.top  = ty + 'px';
            }
            function hideTip() { tooltip.classList.remove('visible'); }

            /* Activate a country by numeric ID string */
            function activateCountry(numId) {
                activeId = numId;
                svg.selectAll('.geo-path-highlight')
                    .classed('active', d => String(d.id) === numId);
                legendItems.forEach(li => {
                    li.classList.toggle('active', SLUG_TO_ID[li.dataset.country] === numId);
                });
            }

            /* ────────────────────────────────────
               Fetch world topology & render
            ──────────────────────────────────── */
            fetch('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-50m.json')
                .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
                .then(world => {
                    loadingEl.style.display = 'none';

                    const allFeatures = topojson.feature(world, world.objects.countries).features;
                    const hlFeatures  = allFeatures.filter(d => !!COUNTRIES[String(d.id)]);
                    const bgFeatures  = allFeatures.filter(d =>  !COUNTRIES[String(d.id)]);

                    /*
                     * AUTO-FIT the projection so every highlighted country
                     * is visible with comfortable padding.
                     * fitExtent([[topLeft], [bottomRight]], featureCollection)
                     * automatically computes the correct scale + translate.
                     */
                    projection.fitExtent(
                        [[55, 40], [W - 40, H - 40]],
                        { type: 'FeatureCollection', features: hlFeatures }
                    );

                    /* Background (grey) countries */
                    svg.append('g')
                        .selectAll('path')
                        .data(bgFeatures)
                        .join('path')
                        .attr('class', 'geo-path-world')
                        .attr('d', pathGen);

                    /* Highlighted countries */
                    svg.append('g')
                        .selectAll('path')
                        .data(hlFeatures)
                        .join('path')
                        .attr('class', 'geo-path-highlight')
                        .attr('id',    d => 'geo-path-' + String(d.id))
                        .attr('d', pathGen)
                        .on('mouseenter', function(event, d) {
                            const info = COUNTRIES[String(d.id)];
                            showTip(info.name, info.region, event.clientX, event.clientY);
                            activateCountry(String(d.id));
                        })
                        .on('mousemove',  (event) => moveTip(event.clientX, event.clientY))
                        .on('mouseleave', hideTip)
                        .on('click',      (event, d) => activateCountry(String(d.id)));

                    /* ── Corridor lines (capital to capital) ── */
                    const corridors = [
                        ['417', '860', '795', '31', '268'],   // Kyrgyzstan → Uzbekistan → Turkmenistan → Azerbaijan → Georgia
                        ['398', '31'],                         // Kazakhstan → Azerbaijan
                        ['268', '792', '642', '300'],          // Georgia → Turkey → Romania → Greece
                        ['792', '756'],                        // Turkey → Switzerland
                        ['784', '31'],                         // UAE → Azerbaijan
                    ];

                    const corrG = svg.append('g');
                    corridors.forEach(seg => {
                        for (let i = 0; i < seg.length - 1; i++) {
                            const a  = projection(COUNTRIES[seg[i]]?.capital);
                            const b  = projection(COUNTRIES[seg[i+1]]?.capital);
                            if (!a || !b || isNaN(a[0]) || isNaN(b[0])) continue;
                            const mx = (a[0] + b[0]) / 2;
                            const my = (a[1] + b[1]) / 2 - Math.abs(b[0] - a[0]) * 0.12;
                            corrG.append('path')
                                .attr('class', 'geo-corridor')
                                .attr('d', `M${a[0]},${a[1]} Q${mx},${my} ${b[0]},${b[1]}`);
                        }
                    });

                    /* ── Capital dots ── */
                    const dotG = svg.append('g');
                    Object.entries(COUNTRIES).forEach(([id, info]) => {
                        const pt = projection(info.capital);
                        if (!pt || isNaN(pt[0])) return;

                        dotG.append('circle')
                            .attr('class', 'geo-dot-halo')
                            .attr('cx', pt[0]).attr('cy', pt[1])
                            .attr('r', 7);

                        dotG.append('circle')
                            .attr('class', 'geo-dot-core')
                            .attr('id',   'geo-dot-' + id)
                            .attr('cx', pt[0]).attr('cy', pt[1])
                            .attr('r', 3);
                    });

                    /* ── Country labels – all 11 countries ── */
                    const labelCfg = {
                        '398': { size: 11,  dy:  20 },  // Kazakhstan
                        '792': { size: 10,  dy:  18 },  // Turkey
                        '795': { size: 9,   dy:  16 },  // Turkmenistan
                        '860': { size: 9,   dy:  16 },  // Uzbekistan
                        '642': { size: 8,   dy: -13 },  // Romania
                        '784': { size: 8,   dy: -13 },  // UAE
                        '300': { size: 8,   dy: -13 },  // Greece
                        '268': { size: 7.5, dy: -12 },  // Georgia
                        '31':  { size: 7.5, dy:  15 },  // Azerbaijan
                        '417': { size: 7.5, dy: -12 },  // Kyrgyzstan
                        '756': { size: 7.5, dy: -12 },  // Switzerland
                    };

                    const lblG = svg.append('g').attr('pointer-events', 'none');
                    Object.entries(labelCfg).forEach(([id, cfg]) => {
                        const info = COUNTRIES[id];
                        if (!info) return;
                        const pt = projection(info.capital);
                        if (!pt || isNaN(pt[0])) return;
                        lblG.append('text')
                            .attr('class', 'geo-label')
                            .attr('x', pt[0])
                            .attr('y', pt[1] + cfg.dy)
                            .attr('text-anchor', 'middle')
                            .attr('font-size', cfg.size)
                            .text(info.name.toUpperCase());
                    });

                    /* ── Scroll-triggered entrance animation ── */
                    ScrollTrigger.create({
                        trigger: '#geoMapWrap', start: 'top 80%', once: true,
                        onEnter() {
                            gsap.fromTo('.geo-path-world',
                                { opacity: 0 },
                                { opacity: 1, duration: 0.8, ease: 'power1.out' });
                            gsap.fromTo('.geo-path-highlight',
                                { opacity: 0 },
                                { opacity: 1, stagger: 0.06, duration: 0.55, ease: 'power2.out', delay: 0.2 });
                            gsap.fromTo('.geo-corridor',
                                { opacity: 0 },
                                { opacity: 1, stagger: 0.08, duration: 0.5, ease: 'power1.out', delay: 0.55 });
                            gsap.fromTo('.geo-dot-core, .geo-dot-halo',
                                { scale: 0, transformOrigin: 'center' },
                                { scale: 1, stagger: 0.05, duration: 0.4, ease: 'back.out(2.5)', delay: 0.8 });
                            gsap.fromTo('.geo-label',
                                { opacity: 0 },
                                { opacity: 1, duration: 0.5, delay: 1.2 });
                        }
                    });

                })
                .catch(err => {
                    console.error('Map load failed:', err);
                    loadingEl.textContent = 'Map unavailable';
                });

            /* ── Legend click handler ── */
            legendItems.forEach(item => {
                item.addEventListener('click', function () {
                    const numId = SLUG_TO_ID[this.dataset.country];
                    if (!numId) return;
                    activateCountry(numId);

                    const r = wrap.getBoundingClientRect();
                    if (r.top < 0 || r.bottom > window.innerHeight) {
                        wrap.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    const el = document.getElementById('geo-path-' + numId);
                    if (el) {
                        gsap.fromTo(el,
                            { opacity: 0.15 },
                            { opacity: 1, duration: 0.45, ease: 'power2.out' });
                    }
                });
            });

        })();
    </script>

</x-public-layout>