<script>
    /* ── Page transition — /// stripes ───────────────────────── */
    (function () {
        var ss = document.querySelectorAll('.pt-s');
        if (!ss.length) return;

        document.addEventListener('click', function (e) {
            var link = e.target.closest('a[href]');
            if (!link) return;

            var href = link.getAttribute('href');
            if (!href || href === '#' || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) return;
            if (link.target === '_blank' || link.hasAttribute('download')) return;

            try {
                var url = new URL(href, window.location.origin);
                if (url.origin !== window.location.origin) return;
                if (url.pathname === window.location.pathname) return;
            } catch (err) { return; }

            e.preventDefault();

            var W = window.innerWidth;
            gsap.killTweensOf(ss);
            /* Park off-screen left, then sweep in to cover */
            gsap.set(ss, { x: -W * 1.26 });
            gsap.to(ss, {
                x: 0,
                duration : 0.65,
                ease     : 'power3.inOut',
                stagger  : { each: 0.08 },
                onComplete: function () { window.location.href = href; }
            });
        });
    })();

    gsap.registerPlugin(ScrollTrigger);

    /* ── Marquee skew on scroll ──────────────────────────────── */
    (function () {
        const marquees = document.querySelectorAll('.marquee-content');
        if (!marquees.length) return;

        let proxy     = { skew: 0 };
        let skewSetter = gsap.quickSetter(".marquee-content", "skewX", "deg");
        let clamp      = gsap.utils.clamp(-10, 10);

        ScrollTrigger.create({
            onUpdate: (self) => {
                let skew = clamp(self.getVelocity() / -300);
                if (Math.abs(skew) > 0.1) {
                    proxy.skew = skew;
                    gsap.to(proxy, {
                        skew: 0, duration: 0.8, ease: "power3.out",
                        overwrite: true,
                        onUpdate: () => skewSetter(proxy.skew)
                    });
                }
            }
        });
    })();

    /* ── Impact section (used on some inner pages) ───────────── */
    (function () {
        if (!document.querySelector('.impact-section')) return;

        gsap.fromTo(".impact-title, .impact-desc, .impact-btn",
            { y: 50, opacity: 0 },
            {
                scrollTrigger: { trigger: ".impact-section", start: "top 75%" },
                y: 0, opacity: 1, duration: 1, stagger: 0.2, ease: "power3.out"
            }
        );

        const stats = document.querySelectorAll('.stat-item');
        if (stats.length) {
            gsap.fromTo(stats,
                { y: 50, opacity: 0 },
                {
                    scrollTrigger: { trigger: ".impact-stats", start: "top 85%" },
                    y: 0, opacity: 1, duration: 1, stagger: 0.15, ease: "power3.out",
                    onStart: () => {
                        document.querySelectorAll('.stat-number').forEach(num => {
                            const target = +num.getAttribute('data-target');
                            gsap.to(num, {
                                innerHTML: target, duration: 2, ease: "power2.out",
                                snap: { innerHTML: 1 },
                                onUpdate: function () {
                                    num.innerHTML = Math.ceil(this.targets()[0].innerHTML);
                                }
                            });
                        });
                    }
                }
            );
        }
    })();
</script>
