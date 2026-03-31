<x-public-layout>

    <style>
        /* ── PAGE HERO ── */
        .page-hero {
            min-height: 68vh; padding: 0;
            background: var(--bg-dark);
            position: relative; z-index: 2; overflow: hidden;
            display: flex; flex-direction: column; justify-content: flex-end;
        }
        .page-hero-bg {
            position: absolute; inset: 0; z-index: 0;
            background: url('/assets/public/images/contacts-hero.jfif') center/cover no-repeat;
        }
        .page-hero-bg::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(2,12,26,0.88) 0%, rgba(10,32,64,0.78) 50%, rgba(2,12,26,0.92) 100%);
        }
        .page-hero::before {
            content: 'CONTACT';
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

        /* ── Parallax Break ── */
        .parallax-break {
            height: 420px;
            position: relative; overflow: hidden;
        }
        .parallax-break-img {
            position: absolute; top: -25%; left: 0; right: 0; bottom: -25%;
            background: center/cover no-repeat;
            will-change: transform;
        }
        .parallax-break-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, rgba(2,12,26,0.35) 0%, rgba(2,12,26,0.50) 100%);
        }

        /* ── CONTACT INFO CARDS ── */
        .cinfo-section {
            padding: 80px 5%;
            background: var(--bg-alt);
        }
        .cinfo-grid {
            max-width: var(--container); margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
        }
        .cinfo-card {
            padding: 32px 28px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            transition: all 0.3s;
        }
        .cinfo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(34,119,187,0.1);
            border-color: rgba(34,119,187,0.25);
        }
        .cc-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: rgba(34,119,187,0.07); border: 1px solid rgba(34,119,187,0.1);
            display: flex; align-items: center; justify-content: center;
            color: var(--blue); margin-bottom: 18px;
        }
        .cc-label {
            font-family: var(--font-head); font-size: 9px;
            color: var(--text-light); letter-spacing: 0.14em;
            text-transform: uppercase; margin-bottom: 6px; display: block;
        }
        .cc-value {
            font-size: 1rem; color: var(--text); font-weight: 600;
            line-height: 1.5; text-decoration: none; display: block;
            transition: color 0.25s;
        }
        a.cc-value:hover { color: var(--blue); }

        /* ── MAIN CONTACT SECTION ── */
        .cmain-section {
            padding: 120px 5%;
            background: var(--bg);
        }
        .cmain-inner {
            max-width: var(--container); margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1.1fr; gap: 100px;
            align-items: start;
        }
        .cmain-left-title {
            font-family: var(--font-head); font-size: clamp(2rem, 4vw, 3rem);
            color: var(--text); line-height: 1.1; margin-bottom: 20px;
            letter-spacing: -0.02em;
        }
        .cmain-left-desc {
            font-size: 1rem; color: var(--text-muted); line-height: 1.8;
            margin-bottom: 44px;
        }
        .offices { display: flex; flex-direction: column; gap: 16px; }
        .office-card {
            padding: 22px 26px;
            border: 1px solid var(--border); border-radius: 14px;
            transition: border-color 0.3s;
        }
        .office-card:hover { border-color: rgba(34,119,187,0.3); }
        .oc-tag {
            font-family: var(--font-head); font-size: 9px;
            color: var(--orange); letter-spacing: 0.16em; text-transform: uppercase;
            margin-bottom: 6px; display: block;
        }
        .oc-name { font-weight: 600; color: var(--text); margin-bottom: 4px; font-size: 0.95rem; }
        .oc-addr { font-size: 0.88rem; color: var(--text-muted); line-height: 1.55; }

        /* ── FORM ── */
        .cform { display: flex; flex-direction: column; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0 28px; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .cinfo-grid { grid-template-columns: repeat(2, 1fr); }
            .cmain-inner { grid-template-columns: 1fr; gap: 60px; }
        }
        @media (max-width: 768px) {
            .page-hero-inner { padding: 110px 5% 56px; }
            .cinfo-section { padding: 56px 5%; }
            .cmain-section { padding: 80px 5%; }
        }
        @media (max-width: 600px) {
            .page-hero-inner { padding: 96px 5% 44px; }
            .cinfo-section { padding: 44px 5%; }
            .cmain-section { padding: 60px 5%; }
            .cinfo-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .page-title { font-size: clamp(3rem, 13vw, 5rem); }
        }
    </style>

    {{-- PAGE HERO --}}
    <section class="page-hero">
        <div class="page-hero-bg" id="contactsHeroBg"></div>
        <div class="page-hero-inner">
            <span class="page-eyebrow ph-anim">{{ _t($p['contacts_eyebrow']->title ?? '') }}</span>
            <h1 class="page-title ph-anim">
                {{ _t($p['contacts_title_line1']->title ?? '') }}<br>
                <span class="t-blue">{{ _t($p['contacts_title_line2']->title ?? '') }}</span>
            </h1>
            <p class="page-hero-desc ph-anim">{{ _t($p['contacts_hero_desc']->title ?? '') }}</p>
        </div>
    </section>

    {{-- CONTACT INFO CARDS --}}
    <div class="cinfo-section">
        <div class="cinfo-grid">

            @if(isset($contacts_info) && $contacts_info->isNotEmpty())
                @foreach($contacts_info as $info)
                    <div class="cinfo-card ci-anim">
                        <div class="cc-icon">
                            @if(_t($info->options2) == 'email')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            @elseif(_t($info->options2) == 'phone')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.63 4.9 2 2 0 0 1 3.6 2.72h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.3a16 16 0 0 0 6 6l.86-.86a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.72 18l.2-1.08z"/>
                                </svg>
                            @elseif(_t($info->options2) == 'clock')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            @endif
                        </div>
                        <span class="cc-label">{{ _t($info->short_content) }}</span>
                        @if(_t($info->options))
                            <a href="{{ _t($info->options) }}" class="cc-value">{{ _t($info->title) }}</a>
                        @else
                            <span class="cc-value">{{ _t($info->title) }}</span>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </div>

    {{-- PARALLAX BREAK --}}
    <div class="parallax-break">
        <div class="parallax-break-img" style="background-image:url('/assets/public/images/parallax-contacts.jpeg');" data-parallax></div>
        <div class="parallax-break-overlay"></div>
    </div>

    {{-- MAIN CONTACT + FORM --}}
    <section class="cmain-section">
        <div class="cmain-inner">

            <div class="cmain-left">
                <h2 class="cmain-left-title">
                    {!! _t($p['contacts_partnership_title']->title ?? '') !!}
                </h2>
                <p class="cmain-left-desc">
                    {{ _t($p['contacts_partnership_desc']->title ?? '') }}
                </p>

                <div class="offices">
                    @if(isset($offices) && $offices->isNotEmpty())
                        @foreach($offices as $office)
                            <div class="office-card">
                                <span class="oc-tag">{{ _t($office->options) }}</span>
                                <div class="oc-name">{{ _t($office->title) }}</div>
                                <div class="oc-addr">{!! _t($office->short_content) !!}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="cmain-right">

                @if(session('form_success'))
                    <div class="cform-success">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <p>{{ _t($p['form_success_msg']->title ?? 'Your message has been sent. We will get back to you shortly.') }}</p>
                    </div>
                @else
                <form class="cform" action="{{ route('form.contact') }}" method="POST">
                    @csrf

                    @if($errors->has('captcha_code'))
                        <div class="cform-error">{{ $errors->first('captcha_code') }}</div>
                    @endif

                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" id="c_name" name="fio" class="form-input" placeholder=" " value="{{ old('fio') }}" required>
                            <label for="c_name" class="form-label">{{ _t($p['form_your_name']->title ?? 'Your Name') }}</label>
                            <div class="input-border"></div>
                        </div>
                          <div class="form-group">
                            <input type="tel" id="c_phone" name="phone" class="form-input" placeholder=" " value="{{ old('phone') }}" required>
                            <label for="c_phone" class="form-label">{{ _t($p['form_phone_optional']->title ?? 'Phone (optional)') }}</label>
                            <div class="input-border"></div>
                        </div>
                        <!-- <div class="form-group">
                            <input type="text" id="c_company" name="address" class="form-input" placeholder=" " value="{{ old('address') }}">
                            <label for="c_company" class="form-label">{{ _t($p['form_company_optional']->title ?? 'Company') }}</label>
                            <div class="input-border"></div>
                        </div> -->
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <input type="email" id="c_email" name="email" class="form-input" placeholder=" " value="{{ old('email') }}" required>
                            <label for="c_email" class="form-label">{{ _t($p['form_email_address']->title ?? 'Email Address') }}</label>
                            <div class="input-border"></div>
                        </div>
                      
                    </div>

                    <!-- <div class="form-group">
                        <input type="text" id="c_subject" name="subject" class="form-input" placeholder=" " value="{{ old('subject') }}">
                        <label for="c_subject" class="form-label">{{ _t($p['form_subject']->title ?? 'Subject / Commodity Interest') }}</label>
                        <div class="input-border"></div>
                    </div> -->

                    <div class="form-group">
                        <textarea id="c_message" name="message" class="form-input form-textarea" placeholder=" " rows="1">{{ old('message') }}</textarea>
                        <label for="c_message" class="form-label">{{ _t($p['form_how_can_we_help']->title ?? 'Your Message') }}</label>
                        <div class="input-border"></div>
                    </div>

                    {{-- Captcha --}}
                    <div class="form-captcha">
                        <div class="captcha-img-wrap">
                            <img id="captcha-img" src="{{ route('captcha') }}" alt="captcha" class="captcha-img">
                            <button type="button" class="captcha-refresh" onclick="refreshCaptcha()" title="Refresh">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                            </button>
                        </div>
                        <div class="form-group captcha-input-group">
                            <input type="text" id="captcha_code" name="captcha_code" class="form-input" placeholder="Enter CAPTCHA " autocomplete="off" required>
                            <label for="captcha_code" class="form-label">{{ _t($p['form_captcha_label']->title ?? 'Enter code above') }}</label>
                            <div class="input-border"></div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>{{ _t($p['send_message']->title ?? 'Send Message') }}</span>
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

        /* Hero entrance */
        gsap.fromTo(".ph-anim", { y: 40, opacity: 0 }, {
            y: 0, opacity: 1, duration: 1.1, stagger: 0.18,
            ease: "power3.out", delay: 0.3
        });

        /* Hero bg parallax */
        const contactsHeroBg = document.getElementById('contactsHeroBg');
        if (contactsHeroBg) {
            gsap.to(contactsHeroBg, {
                yPercent: 18, ease: 'none',
                scrollTrigger: { trigger: '.page-hero', start: 'top top', end: 'bottom top', scrub: true }
            });
        }

        /* Parallax image breaks */
        document.querySelectorAll('[data-parallax]').forEach(el => {
            gsap.to(el, {
                yPercent: 22, ease: 'none',
                scrollTrigger: { trigger: el.closest('.parallax-break'), start: 'top bottom', end: 'bottom top', scrub: true }
            });
        });

        /* Info cards stagger */
        gsap.utils.toArray('.ci-anim').forEach((el, i) => {
            gsap.set(el, { opacity: 0, y: 24 });
            ScrollTrigger.create({
                trigger: el, start: "top 88%",
                onEnter: () => gsap.to(el, {
                    opacity: 1, y: 0, duration: 0.85,
                    delay: (i % 4) * 0.1, ease: "power3.out"
                })
            });
        });

        /* Main section slide in */
        gsap.set(['.cmain-left', '.cmain-right'], { opacity: 0 });
        ScrollTrigger.create({
            trigger: '.cmain-section', start: "top 75%",
            onEnter: () => {
                gsap.to('.cmain-left',  { opacity: 1, x: 0, duration: 1,   ease: "power3.out" });
                gsap.to('.cmain-right', { opacity: 1, x: 0, duration: 1,   ease: "power3.out", delay: 0.15 });
            }
        });
        gsap.set('.cmain-left',  { x: -40 });
        gsap.set('.cmain-right', { x:  40 });

        /* Auto-expand textarea */
        const ta = document.getElementById('c_message');
        if (ta) {
            ta.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }

        /* Captcha refresh */
        function refreshCaptcha() {
            const img = document.getElementById('captcha-img');
            if (img) img.src = '{{ route('captcha') }}?t=' + Date.now();
        }
    </script>
    <style>
        .form-captcha { display: flex; gap: 16px; align-items: flex-end; margin-bottom: 4px; }
        .captcha-img-wrap { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .captcha-img { height: 48px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.05); }
        .captcha-refresh { background: none; border: none; cursor: pointer; color: inherit; opacity: 0.6; padding: 4px; transition: opacity .2s; }
        .captcha-refresh:hover { opacity: 1; }
        .captcha-input-group { flex: 1; margin-bottom: 0; }
        .cform-success { text-align: center; padding: 48px 24px; }
        .cform-success svg { opacity: 0.7; margin-bottom: 16px; }
        .cform-success p { opacity: 0.8; }
        .cform-error { background: rgba(220,50,50,0.12); border: 1px solid rgba(220,50,50,0.3); border-radius: 6px; padding: 10px 14px; margin-bottom: 16px; font-size: 0.9rem; color: #ff6b6b; }
    </style>

</x-public-layout>
