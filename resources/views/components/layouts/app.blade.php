<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'Papan Informasi Digital' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --gap: 0.75rem;
            --color-bg: #f0f2f5;
            --color-surface: #ffffff;
            --color-surface-alt: #f7f8fa;
            --color-border: #e4e7ec;
            --color-border-light: #eef0f4;
            --color-text-primary: #1a1d23;
            --color-text-secondary: #5f6875;
            --color-text-muted: #8f96a3;
            --color-accent: #2563eb;
            --color-accent-soft: #eff4ff;
            --color-success: #16a34a;
            --color-success-soft: #f0fdf4;
            --color-warning: #d97706;
            --color-warning-soft: #fffbeb;
            --color-danger: #dc2626;
            --color-danger-soft: #fef2f2;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        /* ===== DARK MODE TOKENS ===== */
        [data-theme="dark"] {
            --color-bg: #0f1117;
            --color-surface: #1a1d27;
            --color-surface-alt: #222632;
            --color-border: #2e3345;
            --color-border-light: #252a3a;
            --color-text-primary: #e8eaf0;
            --color-text-secondary: #9ca3b4;
            --color-text-muted: #6b7280;
            --color-accent: #60a5fa;
            --color-accent-soft: rgba(96, 165, 250, 0.12);
            --color-success: #4ade80;
            --color-success-soft: rgba(74, 222, 128, 0.12);
            --color-warning: #fbbf24;
            --color-warning-soft: rgba(251, 191, 36, 0.12);
            --color-danger: #f87171;
            --color-danger-soft: rgba(248, 113, 113, 0.12);
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 4px 16px rgba(0, 0, 0, 0.4);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--color-bg);
            color: var(--color-text-primary);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ===== TICKER / MARQUEE ===== */
        .ticker {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .ticker>span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* ===== RESPONSIVE TYPOGRAPHY (clamp-based) ===== */
        .tv-heading {
            font-size: clamp(0.95rem, 1vw + 0.5rem, 1.35rem);
            font-weight: 700;
            color: var(--color-text-primary);
            letter-spacing: -0.01em;
        }

        .tv-sub {
            font-size: clamp(0.7rem, 0.8vw + 0.3rem, 0.92rem);
        }

        .tv-cell {
            font-size: clamp(0.72rem, 0.75vw + 0.28rem, 0.9rem);
        }

        .tv-time {
            font-variant-numeric: tabular-nums;
        }

        /* ===== AUTO-SCROLL CONTAINER ===== */
        .scroll-container {
            position: relative;
            overflow: hidden;
            mask-image: linear-gradient(to bottom, transparent 0%, black 6%, black 94%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 6%, black 94%, transparent 100%);
        }

        .scroll-track {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        /* ===== CARD DESIGN ===== */
        .data-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-sm);
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .data-card:hover {
            background: var(--color-surface-alt);
            border-color: var(--color-border);
        }

        /* ===== SECTION PANEL ===== */
        .panel {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* ===== TABLE HEADER ROW ===== */
        .table-header {
            background: var(--color-surface-alt);
            border: 1px solid var(--color-border-light);
            border-radius: var(--radius-sm);
            color: var(--color-text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* ===== STATUS BADGES ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3em;
            padding: 0.3em 0.7em;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8em;
            letter-spacing: 0.01em;
        }

        .badge--success {
            background: var(--color-success-soft);
            color: var(--color-success);
        }

        .badge--danger {
            background: var(--color-danger-soft);
            color: var(--color-danger);
        }

        .badge--warning {
            background: var(--color-warning-soft);
            color: var(--color-warning);
        }

        /* ===== HEADER BAR ===== */
        .header-bar {
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            box-shadow: var(--shadow-sm);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* ===== FULLSCREEN BUTTON ===== */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.4em;
            padding: 0.5em 1em;
            background: var(--color-surface-alt);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            color: var(--color-text-secondary);
            font-weight: 500;
            font-size: clamp(0.72rem, 0.7vw + 0.28rem, 0.88rem);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-action:hover {
            background: var(--color-border-light);
            color: var(--color-text-primary);
        }

        /* ===== RUNNING TEXT FOOTER ===== */
        .footer-bar {
            background: var(--color-surface);
            border-top: 1px solid var(--color-border);
            box-shadow: 0 -1px 4px rgba(0, 0, 0, 0.03);
        }

        /* ===== LIVE INDICATOR DOT ===== */
        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--color-accent);
            position: relative;
        }

        .live-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: var(--color-accent);
            opacity: 0.3;
            animation: live-pulse 2s ease-in-out infinite;
        }

        @keyframes live-pulse {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0;
                transform: scale(1.8);
            }
        }

        /* ===== SECTION ICON ===== */
        .section-icon {
            width: clamp(28px, 2vw, 36px);
            height: clamp(28px, 2vw, 36px);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .section-icon svg {
            width: 55%;
            height: 55%;
        }

        /* ===== YOUTUBE EMBED ===== */
        .video-frame {
            border-radius: var(--radius-md);
            overflow: hidden;
            background: #000;
            border: 1px solid var(--color-border);
        }

        /* ===== CUSTOM SCROLLBAR (minimal) ===== */
        .scroll-track::-webkit-scrollbar {
            width: 3px;
        }

        .scroll-track::-webkit-scrollbar-track {
            background: transparent;
        }

        .scroll-track::-webkit-scrollbar-thumb {
            background: var(--color-border);
            border-radius: 3px;
        }

        /* ===== TIME CHIP ===== */
        .time-chip {
            background: var(--color-surface-alt);
            border: 1px solid var(--color-border-light);
            border-radius: 6px;
            padding: 0.25em 0.6em;
            font-weight: 600;
            color: var(--color-text-primary);
        }

        /* ===== JENJANG BADGE (S1/S2) ===== */
        .jenjang-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--color-accent-soft);
            color: var(--color-accent);
            font-size: 0.7em;
            font-weight: 700;
            padding: 0.2em 0.5em;
            border-radius: 4px;
            letter-spacing: 0.02em;
            line-height: 1;
            white-space: nowrap;
            flex-shrink: 0;
        }
    </style>
    <script>
        /* ===== DARK MODE INIT (before body renders to prevent flash) ===== */
        (function() {
            const saved = localStorage.getItem('papan-theme');
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
            // Sync icons after DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const sunIcon = document.getElementById('icon-sun');
                const moonIcon = document.getElementById('icon-moon');
                if (sunIcon && moonIcon) {
                    sunIcon.style.display = isDark ? 'block' : 'none';
                    moonIcon.style.display = isDark ? 'none' : 'block';
                }
            });
        })();
    </script>
</head>

<body class="h-screen overflow-hidden select-none">
    {{ $slot }}

    <script>
        /* ===== TOAST NOTIFICATIONS ===== */
        window.addEventListener('notify', (e) => {
            const message = e.detail?.message ?? 'Berhasil!';
            const el = document.createElement('div');
            el.className = 'pointer-events-auto mx-auto max-w-sm rounded-lg bg-emerald-600 text-white text-sm px-4 py-2 shadow-lg mb-2';
            el.textContent = message;
            const root = document.getElementById('toast-root');
            if (root) root.appendChild(el);
            setTimeout(() => el.remove(), 2000);
        });

        /* ===== CLOCK ===== */
        const clockEl = document.getElementById('clock');
        function fmt(n) { return n.toString().padStart(2, '0'); }
        function tick() {
            const d = new Date();
            const hari = d.toLocaleDateString('id-ID', { weekday: 'long' });
            const tgl = d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            const jam = `${fmt(d.getHours())}:${fmt(d.getMinutes())}:${fmt(d.getSeconds())}`;
            if (clockEl) clockEl.textContent = `${hari}, ${tgl}  •  ${jam} WIT`;
        }
        setInterval(tick, 1000);
        tick();

        /* ===== FULLSCREEN ===== */
        document.getElementById('btn-full')?.addEventListener('click', async () => {
            try {
                if (!document.fullscreenElement) {
                    await document.documentElement.requestFullscreen();
                } else {
                    await document.exitFullscreen();
                }
            } catch (error) {
                console.log('Fullscreen error:', error);
            }
        });

        /* ===== DARK MODE TOGGLE ===== */
        document.getElementById('btn-theme')?.addEventListener('click', () => {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            if (isDark) {
                html.removeAttribute('data-theme');
                localStorage.setItem('papan-theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                localStorage.setItem('papan-theme', 'dark');
            }
            // Update icon visibility
            const sunIcon = document.getElementById('icon-sun');
            const moonIcon = document.getElementById('icon-moon');
            if (sunIcon && moonIcon) {
                sunIcon.style.display = isDark ? 'none' : 'block';
                moonIcon.style.display = isDark ? 'block' : 'none';
            }
        });

        /* ===== AUTO-SCROLL ===== */
        (function () {
            const containers = document.querySelectorAll('[data-autoscroll="true"]');

            containers.forEach((container) => {
                const track = container.querySelector('.scroll-track');
                if (!track) return;

                const items = Array.from(track.children);
                if (items.length === 0) return;

                const speed = parseInt(container.dataset.speed || 25);

                // Clone items for seamless loop
                if (container.clientHeight < track.scrollHeight) {
                    items.forEach(item => {
                        const clone = item.cloneNode(true);
                        track.appendChild(clone);
                    });
                }

                let offset = 0;
                let isPaused = false;
                let lastTime = performance.now();
                let animationId = null;

                function shouldScroll() {
                    return track.scrollHeight > container.clientHeight + 10;
                }

                function animate(currentTime) {
                    if (!shouldScroll()) {
                        track.style.transform = 'translateY(0)';
                        offset = 0;
                        lastTime = currentTime;
                        animationId = requestAnimationFrame(animate);
                        return;
                    }

                    if (!isPaused) {
                        const deltaTime = (currentTime - lastTime) / 1000;
                        offset += speed * deltaTime;

                        const halfHeight = track.scrollHeight / 2;
                        if (offset >= halfHeight) offset = 0;

                        track.style.transform = `translateY(-${offset}px)`;
                    }

                    lastTime = currentTime;
                    animationId = requestAnimationFrame(animate);
                }

                container.addEventListener('mouseenter', () => { isPaused = true; });
                container.addEventListener('mouseleave', () => { isPaused = false; });
                container.addEventListener('touchstart', () => { isPaused = true; });
                container.addEventListener('touchend', () => { isPaused = false; });

                animationId = requestAnimationFrame(animate);

                let resizeTimeout;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        offset = 0;
                        lastTime = performance.now();
                    }, 250);
                });
            });
        })();
    </script>
</body>

</html>