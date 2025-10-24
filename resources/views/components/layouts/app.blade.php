<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $title ?? 'Papan Infromasi Digital' }}</title>

    <style>
        :root { --gap: .75rem; }
        body { animation: fadeIn .4s ease-out; }
        @keyframes fadeIn { from { opacity: 0 } to { opacity: 1 } }

        /* Ticker animation */
        .ticker { overflow: hidden; white-space: nowrap; position: relative; }
        .ticker > span { display: inline-block; padding-left: 100%; animation: marquee 25s linear infinite; }
        @keyframes marquee { 0% { transform: translateX(0) } 100% { transform: translateX(-100%) } }

        /* Typography */
        .tv-heading { font-size: clamp(1.1rem, 1.2vw + .6rem, 1.5rem); }
        .tv-sub { font-size: clamp(.75rem, .9vw + .35rem, 1rem); }
        .tv-cell { font-size: clamp(.8rem, .85vw + .3rem, 1rem); }
        .tv-time { font-variant-numeric: tabular-nums; }

        /* Auto-scroll container (fade top/bottom) */
        .scroll-container {
            position: relative;
            overflow: hidden;
            mask-image: linear-gradient(to bottom, transparent 0%, black 5%, black 95%, transparent 100%);
        }
        .scroll-track { display: flex; flex-direction: column; gap: var(--gap); }

        /* Card hover effect — lebih glossy */
        .data-card {
            transition: transform 0.35s ease, background 0.35s ease, border-color 0.35s ease;
            background: rgba(255,255,255,0.7);
        }
        .data-card:hover {
            transform: scale(1.02);
            background: linear-gradient(135deg, rgba(255,255,255,0.92), rgba(255,220,220,0.35));
            border-color: rgba(248,113,113,0.45); /* ~red-400 */
        }

        /* Status badge pulse */
        @keyframes pulse-success { 0%, 100% { opacity: 1 } 50% { opacity: 0.85 } }
        .badge-approved { animation: pulse-success 2s ease-in-out infinite; }

        /* Glass effect — merah-putih lembut */
        .glass-effect {
            background: linear-gradient(135deg, rgba(255,255,255,0.35), rgba(255,245,245,0.25), rgba(254,226,226,0.18));
            border: 1px solid rgba(248,113,113,0.35); /* red-400/35 */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Smooth transitions */
        * { transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease; }

        /* Custom scrollbar (optional) */
        .scroll-track::-webkit-scrollbar { width: 4px; }
        .scroll-track::-webkit-scrollbar-track { background: rgba(63,63,70,0.25); }
        .scroll-track::-webkit-scrollbar-thumb {
            background: rgba(161,161,170,0.5);
            border-radius: 2px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-700 via-white to-red-500 text-gray-900 h-screen overflow-hidden select-none">
{{ $slot }}

<script>
    // Clock
    const clockEl = document.getElementById('clock');
    function fmt(n) { return n.toString().padStart(2, '0'); }
    function tick() {
        const d = new Date();
        const hari = d.toLocaleDateString('id-ID', { weekday: 'long' });
        const tgl = d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        const jam = `${fmt(d.getHours())}:${fmt(d.getMinutes())}:${fmt(d.getSeconds())}`;
        if (clockEl) clockEl.textContent = `${hari}, ${tgl} • ${jam} WIT`;
    }
    setInterval(tick, 1000);
    tick();

    // Fullscreen toggle
    document.getElementById('btn-full')?.addEventListener('click', async () => {
        if (!document.fullscreenElement) { await document.documentElement.requestFullscreen(); }
        else { await document.exitFullscreen(); }
    });

    // Enhanced Auto-scroll System (seamless loop + pause on hover)
    (function() {
        const containers = document.querySelectorAll('[data-autoscroll="true"]');
        containers.forEach((container) => {
            const track = container.querySelector('.scroll-track');
            if (!track) return;

            const items = Array.from(track.children);
            if (items.length === 0) return;

            const speed = parseInt(container.dataset.speed || 25);
            const pauseDuration = parseInt(container.dataset.pause || 2000);

            // Clone items for seamless loop
            items.forEach(item => {
                const clone = item.cloneNode(true);
                track.appendChild(clone);
            });

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

            // Pause on hover
            container.addEventListener('mouseenter', () => { isPaused = true; });
            container.addEventListener('mouseleave', () => { isPaused = false; });

            // Start animation
            animationId = requestAnimationFrame(animate);

            // Reset on window resize
            window.addEventListener('resize', () => {
                offset = 0;
                lastTime = performance.now();
            });
        });
    })();
</script>
</body>
</html>
