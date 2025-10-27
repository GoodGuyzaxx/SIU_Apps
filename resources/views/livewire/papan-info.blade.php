<div class="h-full w-full flex flex-col">
    <!-- Enhanced Header Bar -->
    <header class="px-4 md:px-6 py-4 flex items-center justify-between glass-effect rounded-b-2xl mx-4 mb-4 shadow-xl">
        <div class="flex items-center gap-4">
            <div class="floating">
                <h1 class="text-transparent bg-clip-text bg-gradient-to-r from-red-700 via-rose-600 to-red-500 font-black tracking-tight"
                    style="font-size: clamp(1.3rem, 2vw + .6rem, 2.2rem); text-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    Papan Informasi Fakultas
                </h1>
            </div>
{{--            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold--}}
{{--                     bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-lg floating">--}}
{{--                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>--}}
{{--                LIVE STREAM--}}
{{--            </span>--}}
        </div>

        <div class="flex items-center gap-4">
            <div id="clock" class="text-lg font-bold bg-gradient-to-r from-red-700 to-rose-600 bg-clip-text text-transparent drop-shadow-sm"></div>
            <button id="btn-full" class="btn-glass rounded-xl text-red-700 px-4 py-2.5 font-bold flex items-center gap-2 shadow-lg">
                <span>Fullscreen</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
            </button>
        </div>
    </header>

    <main class="grid grid-cols-[2.1fr_1fr] gap-5 md:gap-6 px-4 md:px-6 pb-4 md:pb-6 overflow-hidden h-full">
        <!-- LEFT COLUMN: YouTube + Status Pengajuan -->
        <div class="grid grid-rows-[3fr_1fr] gap-5 min-h-0">
            <!-- Enhanced YouTube Video Section -->
            <section class="glass-effect rounded-3xl p-5 shadow-2xl flex flex-col min-h-0 border border-white/40">
                @php
                    $youtubeUrl = $data[0]->yt_url ?? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
                    $embedUrl = preg_replace([
                      '/https?:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/',
                      '/https?:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
                      '/https?:\/\/m\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/'
                    ], 'https://www.youtube.com/embed/$1?autoplay=1&mute=1&loop=1', $youtubeUrl);
                @endphp
                <div wire:poll.15s class="flex-1 overflow-hidden rounded-xl border-2 border-red-300 bg-black shadow-inner">
                    <iframe class="w-full h-full" src="{{ $embedUrl }}" title="YouTube video" frameborder="0"
                            allow="autoplay; encrypted-media; picture-in-picture"></iframe>
                </div>
            </section>

            <!-- Enhanced Status Pengajuan Judul -->
            <section class="glass-effect rounded-3xl p-5 shadow-2xl flex flex-col min-h-0 border border-white/40">
                <header class="flex items-center justify-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse shadow-lg"></div>
                        <h2 class="tv-heading font-black">
                            Status Pengajuan Judul
                        </h2>
                    </div>
                </header>

                <div class="grid grid-cols-12 px-4 py-3 rounded-2xl bg-gradient-to-r from-red-500/90 via-white to-red-400/90
                  text-red-800 tv-sub font-black border border-white/30 shadow-lg">
                    <div class="col-span-3 text-center">Mahasiswa</div>
                    <div class="col-span-6 text-center">Judul Penelitian</div>
                    <div class="col-span-3 text-center">Status</div>
                </div>

                <div class="mt-4 flex-1 scroll-container" data-autoscroll="true" data-speed="30" data-pause="3000">
                    <div class="scroll-track">
                        @php $statusList = $statusPengajuan ?? collect(); @endphp
                        @foreach($data[0]->pengajuan_judul as $item)
                            @php
                                $status = strtolower($item['status'] ?? '');
                                $approved = ($status === 'disetujui' || $status === 'acc');
                                $rejected = ($status === 'ditolak');
                                $badge = $approved
                                    ? 'badge-approved border-emerald-500/60 text-white font-black shadow-lg'
                                    : ($rejected
                                        ? 'bg-rose-500/20 text-rose-800 border-rose-500/50 font-bold shadow'
                                        : 'bg-amber-500/20 text-amber-800 border-amber-500/50 font-bold shadow');
                                $label = $approved ? '✓ Disetujui' : ($rejected ? '✗ Ditolak' : '⏱ Menunggu');
                            @endphp
                            <article class="data-card grid grid-cols-12 items-center px-4 py-3.5 rounded-2xl border border-white/30 shadow-lg">
                                <div class="col-span-3 tv-cell text-center">
                                    <div class="font-black text-gray-900 leading-tight">{{ $item['nama'] ?? '-' }}</div>
                                    <div class="text-gray-700 text-sm leading-tight mt-1">{{ $item['npm'] ?? '-' }}</div>
                                </div>
                                <div class="col-span-6 tv-cell px-3">
                                    @php $judul = $item['judul'] ?? '-' @endphp
                                    <div class="ticker font-medium"><span>{{ $judul }} &nbsp;&nbsp;•&nbsp;&nbsp; {{ $judul }}</span></div>
                                </div>
                                <div class="col-span-3 tv-cell text-center">
                                    <span class="inline-block px-4 py-2 rounded-xl border-2 {{ $badge }} text-sm shadow-inner">
                                        {{ $label }}
                                    </span>
                                </div>
                            </article>
                        @endforeach
                        @if(empty($data) || empty($data[0]->pengajuan_judul))
                            <p class="text-center text-gray-600 py-8 tv-cell font-medium">Belum ada data pengajuan</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: Proposal & Skripsi -->
        <div class="grid grid-rows-2 gap-5 min-h-0">
            <!-- Enhanced Jadwal Ujian Proposal -->
            <section class="glass-effect rounded-3xl p-5 shadow-2xl flex flex-col min-h-0 border border-white/40">
                <header class="flex items-center justify-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse shadow-lg"></div>
                        <h2 class="tv-heading font-black">
                            Jadwal Ujian Proposal
                        </h2>
                    </div>
                </header>

                <div class="grid grid-cols-12 px-4 py-3 rounded-2xl bg-gradient-to-r from-red-500/90 via-white to-red-400/90
                  text-red-800 tv-sub font-black border border-white/30 shadow-lg">
                    <div class="col-span-4 text-center">Mahasiswa</div>
                    <div class="col-span-4 text-center">Judul</div>
                    <div class="col-span-2 text-center">Tanggal</div>
                    <div class="col-span-2 text-center">Jam</div>
                </div>

                <div class="mt-4 flex-1 scroll-container" data-autoscroll="true" data-speed="25" data-pause="2500">
                    <div class="scroll-track">
                        @php $proposal = $jadwalProposal ?? collect(); @endphp
                        @forelse ($data[0]->jadwal_proposal as $row)
                            <article class="data-card grid grid-cols-12 items-center px-4 py-3 rounded-2xl border border-white/30 shadow-lg">
                                <div class="col-span-4 tv-cell text-center">
                                    <div class="font-black text-gray-900 leading-tight">{{ $row['nama'] ?? '-' }}</div>
                                    <div class="text-gray-700 text-sm leading-tight mt-1">{{ $row['npm'] ?? '-' }}</div>
                                </div>
                                <div class="col-span-4 tv-cell px-3 ticker">
                                    <span class="font-medium">{{ $row['judul'] ?? '-' }} • {{ $row['judul'] ?? '-' }}</span>
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-black text-gray-800">
                                    {{ isset($row['tanggal_hari']) ? \Carbon\Carbon::parse($row['tanggal_hari'])->translatedFormat('d M') : '-' }}
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-black text-red-700 bg-red-50 py-1.5 rounded-lg">
                                    {{ isset($row['waktu']) ? \Carbon\Carbon::parse($row['waktu'])->format('H:i') . ' WIT' : '-' }}
                                </div>
                            </article>
                        @empty
                            <p class="text-center text-gray-600 py-8 tv-cell font-medium">Belum ada jadwal</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Enhanced Jadwal Ujian Skripsi -->
            <section class="glass-effect rounded-3xl p-5 shadow-2xl flex flex-col min-h-0 border border-white/40">
                <header class="flex items-center justify-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse shadow-lg"></div>
                        <h2 class="tv-heading font-black">
                            Jadwal Ujian Skripsi
                        </h2>
                    </div>
                </header>

                <div class="grid grid-cols-12 px-4 py-3 rounded-2xl bg-gradient-to-r from-red-500/90 via-white to-red-400/90
                  text-red-800 tv-sub font-black border border-white/30 shadow-lg">
                    <div class="col-span-4 text-center">Mahasiswa</div>
                    <div class="col-span-4 text-center">Judul</div>
                    <div class="col-span-2 text-center">Tanggal</div>
                    <div class="col-span-2 text-center">Jam</div>
                </div>

                <div class="mt-4 flex-1 scroll-container" data-autoscroll="true" data-speed="25" data-pause="2500">
                    <div class="scroll-track">
                        @php $skripsi = $jadwalSkripsi ?? collect(); @endphp
                        @foreach($data[0]->jadwal_skripsi as $item)
                            <article class="data-card grid grid-cols-12 items-center px-4 py-3 rounded-2xl border border-white/30 shadow-lg">
                                <div class="col-span-4 tv-cell text-center">
                                    <div class="font-black text-gray-900 leading-tight">{{ $item['nama'] ?? '-' }}</div>
                                    <div class="text-gray-700 text-sm leading-tight mt-1">{{ $item['npm'] ?? '-' }}</div>
                                </div>
                                <div class="col-span-4 tv-cell px-3 ticker">
                                    <span class="font-medium">{{ $item['judul'] ?? '-' }} • {{ $item['judul'] ?? '-' }}</span>
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-black text-gray-800">
                                    {{ isset($item['tanggal_hari']) ? \Carbon\Carbon::parse($item['tanggal_hari'])->translatedFormat('d M') : '-' }}
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-black text-red-700 bg-red-50 py-1.5 rounded-lg">
                                    {{ isset($item['waktu']) ? \Carbon\Carbon::parse($item['waktu'])->format('H:i') . ' WIT' : '-' }}
                                </div>
                            </article>
                        @endforeach
                        @if(empty($data) || empty($data[0]->jadwal_skripsi))
                            <p class="text-center text-gray-600 py-8 tv-cell font-medium">Belum ada jadwal</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Enhanced Footer -->
    <footer class="mt-auto glass-effect border-t border-white/30 mx-4 rounded-t-2xl py-3 overflow-hidden shadow-2xl">
        <div class="ticker text-center font-black text-lg tracking-wide bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text">
            <span>Selamat datang di Fakultas Hukum Universitas Doktor Husni Ingratubun Papua — Tetap semangat berkarya! — Jadwal terbaru ujian proposal dan skripsi dapat dilihat pada papan informasi ini — </span>
        </div>
    </footer>
</div>
