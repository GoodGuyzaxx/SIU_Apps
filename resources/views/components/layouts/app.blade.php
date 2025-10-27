<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $title ?? 'Papan Informasi Digital' }}</title>

    <style>
        :root {
            --gap: .75rem;
            --primary-gradient: linear-gradient(135deg, #dc2626, #ec4899, #dc2626);
            --glass-bg: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,245,245,0.15), rgba(254,226,226,0.1));
        }

        body {
            animation: fadeIn .6s ease-out;
            background: linear-gradient(-45deg, #dc2626, #ef4444, #fda4af, #ffffff, #fda4af, #ef4444, #dc2626);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Enhanced Ticker animation */
        .ticker {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        .ticker > span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 20s linear infinite;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        @keyframes marquee {
            0% { transform: translateX(0) }
            100% { transform: translateX(-100%) }
        }

        /* Enhanced Typography */
        .tv-heading {
            font-size: clamp(1.1rem, 1.2vw + .6rem, 1.5rem);
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        .tv-sub { font-size: clamp(.75rem, .9vw + .35rem, 1rem); }
        .tv-cell { font-size: clamp(.8rem, .85vw + .3rem, 1rem); }
        .tv-time { font-variant-numeric: tabular-nums; }

        /* Enhanced Auto-scroll container */
        .scroll-container {
            position: relative;
            overflow: hidden;
            mask-image: linear-gradient(to bottom, transparent 0%, black 8%, black 92%, transparent 100%);
        }
        .scroll-track {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        /* Enhanced Card design with 3D effect */
        .data-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 0 rgba(255,255,255,0.5);
        }
        .data-card:hover {
            transform: translateY(-4px) scale(1.02);
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,240,240,0.8));
            border-color: rgba(248,113,113,0.6);
            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.15),
                0 10px 10px -5px rgba(0, 0, 0, 0.04),
                0 0 0 1px rgba(248,113,113,0.1),
                inset 0 1px 0 0 rgba(255,255,255,0.8);
        }

        /* Enhanced Status badge */
        @keyframes pulse-glow {
            0%, 100% {
                opacity: 1;
                box-shadow: 0 0 5px rgba(34, 197, 94, 0.5);
            }
            50% {
                opacity: 0.9;
                box-shadow: 0 0 15px rgba(34, 197, 94, 0.8);
            }
        }
        .badge-approved {
            animation: pulse-glow 2s ease-in-out infinite;
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        /* Enhanced Glass effect */
        .glass-effect {
            background: var(--glass-bg);
            border: 1px solid rgba(255,255,255,0.4);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.18),
                inset 0 1px 0 0 rgba(255,255,255,0.4),
                inset 0 -1px 0 0 rgba(0,0,0,0.05);
        }

        /* Floating animation for headers */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }
        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Enhanced button styles */
        .btn-glass {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        .btn-glass:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Custom scrollbar */
        .scroll-track::-webkit-scrollbar { width: 6px; }
        .scroll-track::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 3px;
        }
        .scroll-track::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #dc2626, #ec4899);
            border-radius: 3px;
        }
        .scroll-track::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #b91c1c, #db2777);
        }

        /* Shine effect on hover */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }
        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255,255,255,0) 0%,
                rgba(255,255,255,0.1) 50%,
                rgba(255,255,255,0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.6s ease;
            opacity: 0;
        }
        .shine-effect:hover::after {
            opacity: 1;
            transform: rotate(30deg) translate(10%, 10%);
        }
    </style>
</head>
<body class="text-gray-900 h-screen overflow-hidden select-none">
{{ $slot }}

<script>
    // Enhanced Clock with date formatting
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

    // Enhanced Fullscreen toggle
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

    // Enhanced Auto-scroll System with performance improvements
    (function() {
        const containers = document.querySelectorAll('[data-autoscroll="true"]');

        containers.forEach((container) => {
            const track = container.querySelector('.scroll-track');
            if (!track) return;

            const items = Array.from(track.children);
            if (items.length === 0) return;

            const speed = parseInt(container.dataset.speed || 25);
            const pauseDuration = parseInt(container.dataset.pause || 2000);

            // Clone items for seamless loop only if needed
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

            // Enhanced hover handling with touch support
            container.addEventListener('mouseenter', () => { isPaused = true; });
            container.addEventListener('mouseleave', () => { isPaused = false; });
            container.addEventListener('touchstart', () => { isPaused = true; });
            container.addEventListener('touchend', () => { isPaused = false; });

            // Start animation
            animationId = requestAnimationFrame(animate);

            // Optimized resize handler
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

    // Add interactive effects to cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.data-card');
        cards.forEach(card => {
            card.classList.add('shine-effect');
        });
    });
</script>
</body>
</html>
