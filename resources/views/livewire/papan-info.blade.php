<div class="h-full w-full flex flex-col">
    <!-- Enhanced Header Bar -->
    <header class="px-4 md:px-2 py-4 flex items-center justify-between glass-effect rounded-b-2xl mx-4 mb-4 shadow-lg">
        <div class="flex items-center gap-4">
            <div class="floating flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto mr4">
                <h1 class="text-transparent bg-clip-text bg-gradient-to-r from-slate-800 via-slate-600 to-slate-700 font-bold tracking-normal"
                    >
                    Papan Informasi Fakultas
                    <br>
                    Hukum Universitas Doktor Husni Ingratubun Papua
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div id="clock" class="text-base font-semibold bg-gradient-to-r from-slate-700 to-slate-600 bg-clip-text text-transparent"></div>
            <button id="btn-full" class="btn-glass rounded-lg text-slate-700 px-4 py-2.5 font-semibold flex items-center gap-2 shadow-sm">
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
            <section class="glass-effect rounded-2xl p-5 shadow-lg flex flex-col min-h-0 border border-slate-200">
                @php
                    $youtubeUrl = $data[0]->yt_url ?? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
                    $embedUrl = preg_replace([
                      '/https?:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/',
                      '/https?:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
                      '/https?:\/\/m\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/'
                    ], 'https://www.youtube.com/embed/$1', $youtubeUrl);
                @endphp
                <div wire:poll.15s class="flex-1 overflow-hidden border-2 border-red-300 bg-black shadow-inner">
                    <iframe
                        class="w-full h-full"
                        src="{{ $embedUrl }}?&autoplay=1"
                        title="YouTube video"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

            </section>

            <!-- Enhanced Status Pengajuan Judul -->
            <section class="glass-effect rounded-2xl  shadow-lg flex flex-col min-h-0 border border-slate-200">
                <header class="flex items-center justify-center">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-slate-600 animate-pulse"></div>
                        <h2 class="tv-heading font-bold">
                            Status Pengajuan Judul
                        </h2>
                    </div>
                </header>

                <div class="grid grid-cols-12 px-4 py-3 rounded-xl bg-gradient-to-r from-slate-600/90 via-white to-slate-400/90
                  text-slate-700 tv-sub font-semibold border border-slate-300">
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
                                    ? 'badge-approved border-emerald-500 text-white font-semibold'
                                    : ($rejected
                                        ? 'bg-rose-100 text-rose-700 border-rose-300 font-medium'
                                        : 'bg-amber-100 text-amber-700 border-amber-300 font-medium');
                                $label = $approved ? '✓ Disetujui' : ($rejected ? '✗ Ditolak' : '⏱ Menunggu');
                            @endphp
                            <article class="data-card grid grid-cols-12 items-center px-4 py-3 rounded-xl border border-slate-200">
                                <div class="col-span-3 tv-cell text-center">
                                    <div class="font-semibold text-slate-900 leading-tight">{{ $item['nama'] ?? '-' }}</div>
                                    <div class="text-slate-600 text-sm leading-tight mt-1">{{ $item['npm'] ?? '-' }}</div>
                                </div>
                                <div class="col-span-6 tv-cell px-3">
                                    @php $judul = $item['judul'] ?? '-' @endphp
                                    <div class="ticker font-normal"><span>{{ $judul }} &nbsp;&nbsp;•&nbsp;&nbsp; {{ $judul }}</span></div>
                                </div>
                                <div class="col-span-3 tv-cell text-center">
                                    <span class="inline-block px-3 py-1.5 rounded-lg border {{ $badge }} text-xs">
                                        {{ $label }}
                                    </span>
                                </div>
                            </article>
                        @endforeach
                        @if(empty($data) || empty($data[0]->pengajuan_judul))
                            <p class="text-center text-slate-500 py-8 tv-cell font-normal">Belum ada data pengajuan</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: Proposal & Skripsi -->
        <div class="grid grid-rows-2 gap-5 min-h-0">
            <!-- Enhanced Jadwal Ujian Proposal -->
            <section class="glass-effect rounded-2xl p-5 shadow-lg flex flex-col min-h-0 border border-slate-200">
                <header class="flex items-center justify-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-slate-600 animate-pulse"></div>
                        <h2 class="tv-heading font-bold">
                            Jadwal Ujian Proposal
                        </h2>
                    </div>
                </header>

                <div class="grid grid-cols-12 px-4 py-3 rounded-xl bg-gradient-to-r from-slate-600/90 via-white to-slate-400/90
                  text-slate-700 tv-sub font-semibold border border-slate-300">
                    <div class="col-span-4 text-center">Mahasiswa</div>
                    <div class="col-span-4 text-center">Judul</div>
                    <div class="col-span-2 text-center">Tanggal</div>
                    <div class="col-span-2 text-center">Jam</div>
                </div>

                <div class="mt-4 flex-1 scroll-container" data-autoscroll="true" data-speed="25" data-pause="2500">
                    <div class="scroll-track">
                        @php $proposal = $jadwalProposal ?? collect(); @endphp
                        @forelse ($data[0]->jadwal_proposal as $row)
                            <article class="data-card grid grid-cols-12 items-center px-4 py-3 rounded-xl border border-slate-200">
                                <div class="col-span-4 tv-cell text-center">
                                    <div class="font-semibold text-slate-900 leading-tight">{{ $row['nama'] ?? '-' }}</div>
                                    <div class="text-slate-600 text-sm leading-tight mt-1">{{ $row['npm'] ?? '-' }}</div>
                                </div>
                                <div class="col-span-4 tv-cell px-3 ticker">
                                    <span class="font-normal">{{ $row['judul'] ?? '-' }} • {{ $row['judul'] ?? '-' }}</span>
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-semibold text-slate-800">
                                    {{ isset($row['tanggal_hari']) ? \Carbon\Carbon::parse($row['tanggal_hari'])->translatedFormat('d M') : '-' }}
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-semibold text-slate-700 bg-slate-100 py-1.5 rounded">
                                    {{ isset($row['waktu']) ? \Carbon\Carbon::parse($row['waktu'])->format('H:i') . ' WIT' : '-' }}
                                </div>
                            </article>
                        @empty
                            <p class="text-center text-slate-500 py-8 tv-cell font-normal">Belum ada jadwal</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Enhanced Jadwal Ujian Skripsi -->
            <section class="glass-effect rounded-2xl p-5 shadow-lg flex flex-col min-h-0 border border-slate-200">
                <header class="flex items-center justify-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-slate-600 animate-pulse"></div>
                        <h2 class="tv-heading font-bold">
                            Jadwal Ujian Skripsi
                        </h2>
                    </div>
                </header>

                <div class="grid grid-cols-12 px-4 py-3 rounded-xl bg-gradient-to-r from-slate-600/90 via-white to-slate-400/90
                  text-slate-700 tv-sub font-semibold border border-slate-300">
                    <div class="col-span-4 text-center">Mahasiswa</div>
                    <div class="col-span-4 text-center">Judul</div>
                    <div class="col-span-2 text-center">Tanggal</div>
                    <div class="col-span-2 text-center">Jam</div>
                </div>

                <div class="mt-4 flex-1 scroll-container" data-autoscroll="true" data-speed="25" data-pause="2500">
                    <div class="scroll-track">
                        @php $skripsi = $jadwalSkripsi ?? collect(); @endphp
                        @foreach($data[0]->jadwal_skripsi as $item)
                            <article class="data-card grid grid-cols-12 items-center px-4 py-3 rounded-xl border border-slate-200">
                                <div class="col-span-4 tv-cell text-center">
                                    <div class="font-semibold text-slate-900 leading-tight">{{ $item['nama'] ?? '-' }}</div>
                                    <div class="text-slate-600 text-sm leading-tight mt-1">{{ $item['npm'] ?? '-' }}</div>
                                </div>
                                <div class="col-span-4 tv-cell px-3 ticker">
                                    <span class="font-normal">{{ $item['judul'] ?? '-' }} • {{ $item['judul'] ?? '-' }}</span>
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-semibold text-slate-800">
                                    {{ isset($item['tanggal_hari']) ? \Carbon\Carbon::parse($item['tanggal_hari'])->translatedFormat('d M') : '-' }}
                                </div>
                                <div class="col-span-2 tv-cell tv-time text-center font-semibold text-slate-700 bg-slate-100 py-1.5 rounded">
                                    {{ isset($item['waktu']) ? \Carbon\Carbon::parse($item['waktu'])->format('H:i') . ' WIT' : '-' }}
                                </div>
                            </article>
                        @endforeach
                        @if(empty($data) || empty($data[0]->jadwal_skripsi))
                            <p class="text-center text-slate-500 py-8 tv-cell font-normal">Belum ada jadwal</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Enhanced Footer -->
    <footer class="mt-auto glass-effect border-t border-slate-300 mx-4 rounded-t-2xl py-3 overflow-hidden shadow-lg">
        <div class="ticker text-center font-semibold text-base tracking-normal text-slate-700">
            <span>{{$data[0]->running_text ?? 'Selamat datang di Fakultas Hukum Universitas Doktor Husni Ingratubun Papua — Tetap semangat berkarya! — Jadwal terbaru ujian proposal dan skripsi dapat dilihat pada papan informasi ini —'}} </span>
        </div>
    </footer>
</div>
