<x-filament-widgets::widget>
    @php
        $data          = $this->getViewData();
        $user          = $data['user'];
        $prodi         = $data['prodi'];
        $tahunAkademik = $data['tahunAkademik'];
        $greeting      = $data['greeting'];

        $roleLabel = match(strtolower($user?->role ?? '')) {
            'kps'      => 'Ketua Program Studi',
            'admin'    => 'Administrator',
            'dosen'    => 'Dosen',
            'mahasiswa' => 'Mahasiswa',
            default    => ucfirst($user?->role ?? '-'),
        };

        $namaProdi  = $prodi?->nama_prodi ?? 'Tidak Diketahui';
        $jenjang    = $prodi?->jenjang    ?? '';
        $takad      = $tahunAkademik?->takad   ?? '-';
        $periode    = $tahunAkademik?->priode  ?? '-';
        $tahun      = $tahunAkademik?->tahun   ?? '-';
    @endphp

    <div class="kps-hero-widget">
        {{-- ── Kiri: Salam & Info User ─────────────────────────── --}}
        <div class="kps-hero-left">
            <div class="kps-avatar">
                {{ strtoupper(substr($user?->name ?? 'K', 0, 1)) }}
            </div>

            <div class="kps-hero-info">
                <p class="kps-greeting">{{ $greeting }},</p>
                <h2 class="kps-name">{{ $user?->name ?? 'Pengguna' }}</h2>

                <div class="kps-badges">
                    <span class="kps-badge kps-badge-role">
                        <x-heroicon-s-shield-check class="kps-badge-icon" />
                        {{ $roleLabel }}
                    </span>
                    <span class="kps-badge kps-badge-prodi">
                        <x-heroicon-s-academic-cap class="kps-badge-icon" />
                        {{ $jenjang ? $jenjang . ' — ' : '' }}{{ $namaProdi }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── Kanan: Tahun Akademik Aktif ────────────────────── --}}
        <div class="kps-hero-right">
            <div class="kps-ta-card">
                <div class="kps-ta-pulse"></div>
                <p class="kps-ta-label">Tahun Akademik Aktif</p>

                @if($tahunAkademik)
                    <p class="kps-ta-value">{{ $takad }}</p>
                    <div class="kps-ta-meta">
                        <span>Periode {{ $periode }}</span>
                        @if($tahun)
                            <span class="kps-ta-dot">·</span>
                            <span>{{ $tahun }}</span>
                        @endif
                    </div>
                @else
                    <p class="kps-ta-value kps-ta-none">Belum Ditentukan</p>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* ────────────────────────── Container ────────────────────────── */
        .kps-hero-widget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            padding: 1.75rem 2rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #1c1917 0%, #292524 50%, #1c1917 100%);
            border: 1px solid rgba(251,191,36,.18);
            box-shadow: 0 4px 32px rgba(0,0,0,.35);
            overflow: hidden;
            position: relative;
        }

        /* decorative glow blobs */
        .kps-hero-widget::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 40% 60% at 10% 50%, rgba(251,191,36,.08) 0%, transparent 60%),
                radial-gradient(ellipse 30% 50% at 90% 30%, rgba(217,119,6,.07) 0%, transparent 55%);
            pointer-events: none;
        }

        /* ─────────────── Left side ─────────────── */
        .kps-hero-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex: 1;
            min-width: 0;
        }

        /* Avatar circle */
        .kps-avatar {
            flex-shrink: 0;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #b45309);
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 3px rgba(251,191,36,.25);
        }

        .kps-hero-info { min-width: 0; }

        .kps-greeting {
            font-size: .75rem;
            font-weight: 500;
            color: #a78bfa;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin: 0 0 .15rem;
        }

        .kps-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: #fef3c7;
            margin: 0 0 .6rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Badges */
        .kps-badges {
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
        }

        .kps-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .25rem .65rem;
            border-radius: 9999px;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .kps-badge-icon {
            width: .85rem;
            height: .85rem;
            flex-shrink: 0;
        }

        .kps-badge-role {
            background: rgba(251,191,36,.15);
            border: 1px solid rgba(251,191,36,.35);
            color: #fbbf24;
        }

        .kps-badge-prodi {
            background: rgba(167,139,250,.12);
            border: 1px solid rgba(167,139,250,.3);
            color: #c4b5fd;
        }

        /* ─────────────── Right side — TA Card ─────────────── */
        .kps-hero-right {
            flex-shrink: 0;
        }

        .kps-ta-card {
            position: relative;
            padding: 1rem 1.4rem;
            border-radius: .875rem;
            background: rgba(251,191,36,.07);
            border: 1px solid rgba(251,191,36,.22);
            text-align: center;
            min-width: 11rem;
        }

        /* Animated active pulse */
        .kps-ta-pulse {
            position: absolute;
            top: .6rem;
            right: .65rem;
            width: .55rem;
            height: .55rem;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 0 rgba(34,197,94,.6);
            animation: kps-pulse 2s infinite;
        }

        @keyframes kps-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(34,197,94,.6); }
            70%  { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
            100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
        }

        .kps-ta-label {
            font-size: .68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #78716c;
            margin: 0 0 .3rem;
        }

        .kps-ta-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fde68a;
            margin: 0 0 .3rem;
        }

        .kps-ta-none {
            color: #ef4444;
            font-size: .95rem;
        }

        .kps-ta-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            font-size: .72rem;
            color: #a8a29e;
        }

        .kps-ta-dot { color: #78716c; }

        /* ─── Responsive ─── */
        @media (max-width: 640px) {
            .kps-hero-widget {
                flex-direction: column;
                align-items: flex-start;
            }
            .kps-hero-right { width: 100%; }
            .kps-ta-card    { min-width: unset; text-align: left; }
        }
    </style>
</x-filament-widgets::widget>
