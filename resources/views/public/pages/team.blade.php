<x-public-layout>

<style>
    /* ── HERO ── */
    .team-hero {
        min-height: 65vh; padding: 0;
        background: var(--bg-dark);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
    }
    .team-hero::before {
        content: 'TEAM';
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
        font-family: var(--font-head); font-size: 28vw; font-weight: 700;
        color: rgba(255,255,255,0.025); white-space: nowrap; pointer-events: none;
        letter-spacing: -0.02em; z-index: 0;
    }
    .team-hero-inner {
        max-width: var(--container); margin: 0 auto;
        position: relative; z-index: 1;
        padding: 160px 5% 90px;
    }
    .team-eyebrow {
        font-family: var(--font-head); font-size: 10px;
        letter-spacing: 0.22em; color: var(--orange);
        margin-bottom: 22px; display: block; text-transform: uppercase;
    }
    .team-title {
        font-family: var(--font-head);
        font-size: clamp(3.5rem, 8vw, 7.5rem);
        line-height: 0.92; color: #fff; letter-spacing: -0.03em;
        font-weight: 700; text-transform: uppercase; margin-bottom: 32px;
    }
    .team-title .t-blue { color: var(--blue); }
    .team-hero-desc {
        font-size: 1.1rem; color: rgba(255,255,255,0.6); line-height: 1.8;
        max-width: 540px;
    }

    /* ── TEAM GRID ── */
    .team-section { background: var(--bg); padding: 100px 5%; }
    .team-section-inner { max-width: var(--container); margin: 0 auto; }
    .team-head { margin-bottom: 64px; }

    .team-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
    }
    .team-card {
        border: 1px solid var(--border); border-radius: 20px;
        overflow: hidden; transition: all 0.3s; background: var(--bg);
    }
    .team-card:hover {
        border-color: rgba(34,119,187,0.3);
        box-shadow: 0 16px 48px rgba(34,119,187,0.08);
        transform: translateY(-4px);
    }
    .tc-photo {
        width: 100%; aspect-ratio: 4/3; overflow: hidden;
        background: var(--bg-alt);
        display: flex; align-items: center; justify-content: center;
        position: relative;
    }
    .tc-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .team-card:hover .tc-photo img { transform: scale(1.04); }
    .tc-placeholder {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 12px; height: 100%; background: var(--bg-alt);
        color: var(--text-light);
    }
    .tc-placeholder-icon {
        width: 64px; height: 64px; border-radius: 50%;
        background: var(--bg); border: 2px dashed var(--border);
        display: flex; align-items: center; justify-content: center;
        color: var(--text-light);
    }
    .tc-placeholder-label {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--text-light);
    }
    .tc-body { padding: 28px 24px; }
    .tc-role {
        font-family: var(--font-head); font-size: 9px;
        letter-spacing: 0.18em; color: var(--orange);
        text-transform: uppercase; margin-bottom: 8px; display: block;
    }
    .tc-name {
        font-family: var(--font-head); font-size: 1.15rem;
        color: var(--text); font-weight: 700; letter-spacing: -0.01em;
        line-height: 1.2; margin-bottom: 10px;
    }
    .tc-desc { font-size: 0.875rem; color: var(--text-muted); line-height: 1.65; }

    /* ── COMING SOON NOTICE ── */
    .team-notice {
        background: var(--bg-alt); padding: 80px 5%; text-align: center;
        border-top: 1px solid var(--border);
    }
    .team-notice-inner { max-width: 520px; margin: 0 auto; }
    .tn-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(34,119,187,0.08); border: 1px solid rgba(34,119,187,0.2);
        display: flex; align-items: center; justify-content: center;
        color: var(--blue); margin: 0 auto 20px;
    }
    .tn-title {
        font-family: var(--font-head); font-size: 1.3rem;
        color: var(--text); font-weight: 700; margin-bottom: 12px;
        letter-spacing: -0.01em;
    }
    .tn-desc { font-size: 0.95rem; color: var(--text-muted); line-height: 1.7; }

    @media (max-width: 1024px) { .team-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 640px)  { .team-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px) {
        .team-title { font-size: clamp(3rem, 13vw, 5rem) !important; }
    }
</style>


{{-- HERO --}}
<section class="team-hero">
    <div class="team-hero-inner">
        <span class="team-eyebrow team-anim">{{ _t($p['team_hero_eyebrow']->title ?? 'People & Leadership') }}</span>
        <h1 class="team-title team-anim">
            {{ _t($p['team_hero_title1']->title ?? 'Our') }}<br><span class="t-blue">{{ _t($p['team_hero_title2']->title ?? 'Team.') }}</span>
        </h1>
        <p class="team-hero-desc team-anim">
            {{ _t($p['team_hero_desc']->title ?? '') }}
        </p>
    </div>
</section>


{{-- TEAM GRID --}}
<section class="team-section">
    <div class="team-section-inner">
        <div class="team-head">
            <span class="section-tag team-head-anim">{{ _t($p['team_section_tag']->title ?? 'Leadership') }}</span>
            <h2 class="section-title team-head-anim">{{ _t($p['team_section_title']->title ?? 'Meet the Team') }}</h2>
        </div>

        @if(!empty($team) && $team->count())
        <div class="team-grid">
            @foreach($team as $member)
            <div class="team-card team-card-anim">
                <div class="tc-photo">
                    @if(!empty($member->files?->img))
                        <img src="{{ asset('uploads/main/' . $member->files->img) }}" alt="{{ _t($member->title) }}">
                    @else
                        <div class="tc-placeholder">
                            <div class="tc-placeholder-icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <span class="tc-placeholder-label">{{ _t($p['team_placeholder_photo']->title ?? 'Photo coming soon') }}</span>
                        </div>
                    @endif
                </div>
                <div class="tc-body">
                    @if(!empty($member->options))
                        <span class="tc-role">{{ $member->options }}</span>
                    @endif
                    <div class="tc-name">{{ _t($member->title) }}</div>
                    @if(!empty(_t($member->short_content ?? '')))
                        <p class="tc-desc">{!! _t($member->short_content) !!}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Placeholder until admin adds team members --}}
        <div class="team-grid">
            @foreach(range(1, 6) as $i)
            <div class="team-card team-card-anim">
                <div class="tc-photo">
                    <div class="tc-placeholder">
                        <div class="tc-placeholder-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <span class="tc-placeholder-label">{{ _t($p['team_placeholder_photo']->title ?? 'Photo coming soon') }}</span>
                    </div>
                </div>
                <div class="tc-body">
                    <span class="tc-role">{{ _t($p['team_placeholder_role']->title ?? 'Leadership') }}</span>
                    <div class="tc-name" style="color:var(--text-light);">{{ _t($p['team_placeholder_name']->title ?? '— To be announced —') }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>


{{-- NOTICE --}}
<section class="team-notice">
    <div class="team-notice-inner">
        <div class="tn-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <h3 class="tn-title">{{ _t($p['team_notice_title']->title ?? 'Team Profiles Coming Soon') }}</h3>
        <p class="tn-desc">
            {{ _t($p['team_notice_desc']->title ?? '') }}
        </p>
    </div>
</section>


<script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.fromTo('.team-anim', { y: 40, opacity: 0 }, {
        y: 0, opacity: 1, duration: 1.1, stagger: 0.18, ease: 'power3.out', delay: 0.3
    });

    gsap.utils.toArray('.team-head-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 20 }, {
            opacity: 1, y: 0, duration: 0.8, delay: i * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });

    gsap.utils.toArray('.team-card-anim').forEach((el, i) => {
        gsap.fromTo(el, { opacity: 0, y: 30 }, {
            opacity: 1, y: 0, duration: 0.75, delay: (i % 3) * 0.1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%' }
        });
    });
</script>

</x-public-layout>
