
    <div class="h-full w-full flex flex-col">
        <!-- Header Bar -->
        <header class="px-4 md:px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-transparent bg-clip-text bg-gradient-to-r from-red-700 via-rose-600 to-red-500 font-extrabold tracking-wide"
                    style="font-size: clamp(1.2rem, 1.6vw + .6rem, 2rem);">
                    Papan Informasi Fakultas
                </h1>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs md:text-sm font-semibold
                     bg-white/60 border border-red-300 text-red-700">
          <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
          Live
        </span>
            </div>

            <div class="flex items-center gap-2">
                <div id="clock" class="text-sm md:text-base font-semibold text-red-800"></div>
                <button id="btn-full" class="ml-2 inline-flex items-center justify-center rounded-lg border border-red-300
                                     bg-white/60 hover:bg-white/80 text-red-700 px-3 py-1.5 font-semibold">
                    Fullscreen
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                    </svg>
                </button>
            </div>
        </header>

        <main class="grid grid-cols-[2.1fr_1fr] gap-4 md:gap-5 px-4 md:px-6 pb-4 md:pb-6 overflow-hidden h-full">
            <!-- LEFT COLUMN: YouTube + Status Pengajuan -->
            <div class="grid grid-rows-[3fr_1fr] gap-4 min-h-0">
                <!-- YouTube Video -->
                <section class="glass-effect rounded-2xl p-4 md:p-5 shadow-2xl flex flex-col min-h-0">
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
                                allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </section>

                <!-- Status Pengajuan Judul -->
                <section class="glass-effect rounded-2xl p-4 md:p-5 shadow-2xl flex flex-col min-h-0">
                    <header class="flex items-center justify-center mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                            <h2 class="tv-heading font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-700 to-rose-500">
                                Status Pengajuan Judul
                            </h2>
                        </div>
                    </header>

                    <div class="grid grid-cols-12 px-3 py-2 rounded-xl bg-gradient-to-r from-red-500 via-white to-red-400
                      text-red-800 tv-sub font-semibold border border-red-300">
                        <div class="col-span-3 text-center">Mahasiswa</div>
                        <div class="col-span-6 text-center">Judul Penelitian</div>
                        <div class="col-span-3 text-center">Status</div>
                    </div>

                    <div class="mt-3 flex-1 scroll-container" data-autoscroll="true" data-speed="30" data-pause="3000">
                        <div class="scroll-track">
                            @php $statusList = $statusPengajuan ?? collect(); @endphp
                            @foreach($data[0]->pengajuan_judul as $item)
                                @php
                                    $status = strtolower($item['status'] ?? '');
                                    $approved = ($status === 'disetujui' || $status === 'acc');
                                    $rejected = ($status === 'ditolak');
                                    $badge = $approved
                                        ? 'bg-emerald-500/20 text-emerald-700 border-emerald-500/40 badge-approved'
                                        : ($rejected
                                            ? 'bg-rose-500/15 text-rose-700 border-rose-500/35'
                                            : 'bg-amber-500/15 text-amber-700 border-amber-500/35');
                                    $label = $approved ? '✓ Disetujui' : ($rejected ? '✗ Ditolak' : '⏱ Menunggu');
                                @endphp
                                <article class="data-card grid grid-cols-12 items-center px-3 py-3 rounded-xl bg-white border border-red-300 shadow-sm">
                                    <div class="col-span-3 tv-cell text-center">
                                        <div class="font-bold text-gray-900 leading-tight">{{ $item['nama'] ?? '-' }}</div>
                                        <div class="text-gray-600 text-sm leading-tight mt-0.5">{{ $item['npm'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-6 tv-cell px-2">
                                        @php $judul = $item['judul'] ?? '-' @endphp
                                        <div class="ticker"><span>{{ $judul }} &nbsp;&nbsp;•&nbsp;&nbsp; {{ $judul }}</span></div>
                                    </div>
                                    <div class="col-span-3 tv-cell text-center">
                    <span class="inline-block px-3 py-1.5 rounded-lg border {{ $badge }} font-bold text-sm">
                      {{ $label }}
                    </span>
                                    </div>
                                </article>
                            @endforeach
                            @if(empty($data) || empty($data[0]->pengajuan_judul))
                                <p class="text-center text-gray-500 py-8 tv-cell">Belum ada data pengajuan</p>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- RIGHT COLUMN: Proposal & Skripsi -->
            <div class="grid grid-rows-2 gap-4 min-h-0">
                <!-- Jadwal Ujian Proposal -->
                <section class="glass-effect rounded-2xl p-4 md:p-5 shadow-2xl flex flex-col min-h-0">
                    <header class="flex items-center justify-center mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                            <h2 class="tv-heading font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-700 to-rose-500">
                                Jadwal Ujian Proposal
                            </h2>
                        </div>
                    </header>

                    <div class="grid grid-cols-12 px-3 py-2 rounded-xl bg-gradient-to-r from-red-500 via-white to-red-400
                      text-red-800 tv-sub font-semibold border border-red-300">
                        <div class="col-span-4 text-center">Mahasiswa</div>
                        <div class="col-span-4 text-center">Judul</div>
                        <div class="col-span-2 text-center">Tanggal</div>
                        <div class="col-span-2 text-center">Jam</div>
                    </div>

                    <div class="mt-3 flex-1 scroll-container" data-autoscroll="true" data-speed="25" data-pause="2500">
                        <div class="scroll-track">
                            @php $proposal = $jadwalProposal ?? collect(); @endphp
                            @forelse ($data[0]->jadwal_proposal as $row)
                                <article class="data-card grid grid-cols-12 items-center px-3 py-2.5 rounded-xl bg-white border border-red-300 shadow-sm">
                                    <div class="col-span-4 tv-cell text-center">
                                        <div class="font-bold text-gray-900 leading-tight">{{ $row['nama'] ?? '-' }}</div>
                                        <div class="text-gray-600 text-sm leading-tight mt-0.5">{{ $row['npm'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-4 tv-cell px-2 ticker">
                                        <span>{{ $row['judul'] ?? '-' }} • {{ $row['judul'] ?? '-' }}</span>
                                    </div>
                                    <div class="col-span-2 tv-cell tv-time text-center font-semibold text-gray-800">
                                        {{ isset($row['tanggal_hari']) ? \Carbon\Carbon::parse($row['tanggal_hari'])->translatedFormat('d M') : '-' }}
                                    </div>
                                    <div class="col-span-2 tv-cell tv-time text-center font-bold text-red-700">
                                        {{ isset($row['waktu']) ? \Carbon\Carbon::parse($row['waktu'])->format('H:i') . ' WIT' : '-' }}
                                    </div>
                                </article>
                            @empty
                                <p class="text-center text-gray-500 py-8 tv-cell">Belum ada jadwal</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <!-- Jadwal Ujian Skripsi -->
                <section class="glass-effect rounded-2xl p-4 md:p-5 shadow-2xl flex flex-col min-h-0">
                    <header class="flex items-center justify-center mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                            <h2 class="tv-heading font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-700 to-rose-500">
                                Jadwal Ujian Skripsi
                            </h2>
                        </div>
                    </header>

                    <div class="grid grid-cols-12 px-3 py-2 rounded-xl bg-gradient-to-r from-red-500 via-white to-red-400
                      text-red-800 tv-sub font-semibold border border-red-300">
                        <div class="col-span-4 text-center">Mahasiswa</div>
                        <div class="col-span-4 text-center">Judul</div>
                        <div class="col-span-2 text-center">Tanggal</div>
                        <div class="col-span-2 text-center">Jam</div>
                    </div>

                    <div class="mt-3 flex-1 scroll-container" data-autoscroll="true" data-speed="25" data-pause="2500">
                        <div class="scroll-track">
                            @php $skripsi = $jadwalSkripsi ?? collect(); @endphp
                            @foreach($data[0]->jadwal_skripsi as $item)
                                <article class="data-card grid grid-cols-12 items-center px-3 py-2.5 rounded-xl bg-white border border-red-300 shadow-sm">
                                    <div class="col-span-4 tv-cell text-center">
                                        <div class="font-bold text-gray-900 leading-tight">{{ $item['nama'] ?? '-' }}</div>
                                        <div class="text-gray-600 text-sm leading-tight mt-0.5">{{ $item['npm'] ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-4 tv-cell px-2 ticker">
                                        <span>{{ $item['judul'] ?? '-' }} • {{ $item['judul'] ?? '-' }}</span>
                                    </div>
                                    <div class="col-span-2 tv-cell tv-time text-center font-semibold text-gray-800">
                                        {{ isset($item['tanggal_hari']) ? \Carbon\Carbon::parse($item['tanggal_hari'])->translatedFormat('d M') : '-' }}
                                    </div>
                                    <div class="col-span-2 tv-cell tv-time text-center font-bold text-red-700">
                                        {{ isset($item['waktu']) ? \Carbon\Carbon::parse($item['waktu'])->format('H:i') . ' WIT' : '-' }}
                                    </div>
                                </article>
                            @endforeach
                            @if(empty($data) || empty($data[0]->jadwal_skripsi))
                                <p class="text-center text-gray-500 py-8 tv-cell">Belum ada jadwal</p>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <footer class="border-t border-red-300 bg-gradient-to-r from-red-600 via-white to-red-500 text-red-800 py-2 overflow-hidden">
            <div class="ticker text-center font-semibold text-lg tracking-wide">
        <span>Selamat datang di Fakultas Hukum Universitas Doktor Husni Ingratubun Papua — Tetap semangat berkarya! —
        Jadwal terbaru ujian proposal dan skripsi dapat dilihat pada papan informasi ini — </span>
            </div>
        </footer>
    </div>

