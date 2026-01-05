<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>403 • Akses Ditolak</title>

    {{-- Jika proyek Anda sudah memuat Tailwind via Vite, hapus CDN di bawah ini --}}
    @vite('resources/css/app.css')

    <meta name="color-scheme" content="light dark" />
</head>
<body class="min-h-dvh bg-gradient-to-b from-red-600/10 to-white dark:from-zinc-900 dark:to-black text-zinc-800 dark:text-zinc-100">
<main class="mx-auto max-w-3xl px-6 py-16 flex min-h-dvh items-center">
    <div class="w-full text-center">
        <!-- Badge 403 -->
        <div class="inline-flex items-center gap-2 rounded-full border border-red-500/20 bg-red-500/10 px-3 py-1 text-sm font-medium text-red-700 dark:text-red-300">
            <span class="inline-block h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
            403 • Akses Ditolak
        </div>

        <!-- Ilustrasi -->
        <div class="mx-auto my-8 w-full max-w-[360px]">
            <!-- SVG ilustrasi 403 (kunci & palang) -->
            <svg viewBox="0 0 400 260" role="img" aria-labelledby="title desc" class="w-full h-auto">
                <title id="title">Ilustrasi 403 Forbidden</title>
                <desc id="desc">Gembok dan palang peringatan</desc>
                <defs>
                    <linearGradient id="grad" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="0%" stop-color="#ef4444"/>
                        <stop offset="100%" stop-color="#f97316"/>
                    </linearGradient>
                </defs>
                <!-- Latar lingkaran -->
                <circle cx="200" cy="130" r="110" fill="url(#grad)" opacity="0.12"/>
                <!-- Gembok -->
                <rect x="150" y="120" width="100" height="80" rx="12" fill="#ef4444" opacity="0.9"/>
                <rect x="170" y="80" width="60" height="60" rx="30" fill="none" stroke="#ef4444" stroke-width="12"/>
                <circle cx="200" cy="160" r="8" fill="#fff"/>
                <rect x="196" y="168" width="8" height="16" rx="3" fill="#fff"/>
                <!-- Palang -->
                <g transform="rotate(-10 200 130)">
                    <rect x="110" y="108" width="180" height="22" rx="6" fill="#fbbf24"/>
                    <rect x="120" y="112" width="160" height="14" rx="4" fill="#111827"/>
                    <g fill="#fbbf24">
                        <rect x="130" y="112" width="18" height="14" rx="2"/>
                        <rect x="168" y="112" width="18" height="14" rx="2"/>
                        <rect x="206" y="112" width="18" height="14" rx="2"/>
                        <rect x="244" y="112" width="18" height="14" rx="2"/>
                    </g>
                </g>
                <!-- Angka 403 -->
                <g fill="#111827" opacity="0.85">
                    <text x="200" y="235" font-size="44" text-anchor="middle" font-weight="700">403</text>
                </g>
            </svg>
        </div>

        <!-- Judul & pesan -->
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Akses Ditolak</h1>
        <p class="mt-3 text-base md:text-lg text-zinc-600 dark:text-zinc-300">
            Anda tidak memiliki izin untuk mengakses halaman ini.
            <span class="block mt-1">
                    {{ $message ?? ($exception->getMessage() ?? 'Silakan kembali dan coba halaman lain atau hubungi administrator.') }}
                </span>
        </p>

        <!-- Tombol aksi -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400/60 transition"
            >
                Ke Beranda
            </a>
        </div>

        <!-- Catatan bantuan -->
        <p class="mt-6 text-xs text-zinc-500 dark:text-zinc-400">
            Kode kesalahan: 403 • Forbidden
        </p>
    </div>
</main>
</body>
</html>
