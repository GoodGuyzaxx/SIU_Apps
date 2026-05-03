<div class="h-full w-full flex flex-col" style="height: 100vh;">

    {{-- ===== HEADER ===== --}}
    <header
        class="header-bar px-[clamp(1rem,2vw,2rem)] py-[clamp(0.6rem,1vh,1rem)] flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-[clamp(0.6rem,1vw,1.25rem)]">
            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                class="h-[clamp(2.5rem,5vh,4rem)] w-auto object-contain">
            <div>
                <h1 class="font-bold text-[clamp(0.85rem,1.1vw+0.3rem,1.3rem)] leading-tight tracking-tight"
                    style="color: var(--color-text-primary);">
                    Papan Informasi Fakultas Hukum
                </h1>
                <p class="text-[clamp(0.65rem,0.7vw+0.2rem,0.85rem)] leading-tight mt-0.5"
                    style="color: var(--color-text-secondary);">
                    Universitas Doktor Husni Ingratubun Papua
                </p>
            </div>
        </div>

        <div class="flex items-center gap-[clamp(0.5rem,1vw,1rem)]">
            <div id="clock" class="text-[clamp(0.7rem,0.75vw+0.25rem,0.9rem)] font-medium hidden sm:block"
                style="color: var(--color-text-secondary);">
            </div>
            <button id="btn-theme" class="btn-action" title="Toggle Dark Mode">
                {{-- Moon icon (shown in light mode) --}}
                <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                {{-- Sun icon (shown in dark mode, hidden by default) --}}
                <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
            <button id="btn-full" class="btn-action" title="Fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
                <span class="hidden md:inline">Fullscreen</span>
            </button>
        </div>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main
        class="flex-1 grid grid-cols-1 lg:grid-cols-[2.2fr_1fr] gap-[clamp(0.5rem,1vw,1rem)] px-[clamp(0.5rem,1.5vw,1.5rem)] py-[clamp(0.35rem,0.8vh,0.75rem)] min-h-0 overflow-hidden">

        {{-- LEFT COLUMN --}}
        <div class="grid grid-rows-[2.8fr_1fr] gap-[clamp(0.5rem,1vw,1rem)] min-h-0">

            {{-- VIDEO SECTION --}}
            <section class="panel flex flex-col min-h-0 overflow-hidden">
                @php
                $youtubeUrl = $player->url ?? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
                $embedUrl = preg_replace([
                '/https?:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/',
                '/https?:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
                '/https?:\/\/m\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
                '/https?:\/\/www\.youtube\.com\/live\/([a-zA-Z0-9_-]+)/'
                ], 'https://www.youtube.com/embed/$1', $youtubeUrl);
                @endphp
                <!-- <div class="flex items-center gap-2 px-[clamp(0.6rem,1vw,1.25rem)] pt-[clamp(0.5rem,0.8vh,0.75rem)] pb-[clamp(0.3rem,0.5vh,0.5rem)] flex-shrink-0">
                    <div class="section-icon" style="background: #fef2f2;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ef4444">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0C.488 3.45.029 5.804 0 12c.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0C23.512 20.55 23.971 18.196 24 12c-.029-6.185-.484-8.549-4.385-8.816zM9 16V8l8 4-8 4z"/>
                        </svg>
                    </div>
                    <span class="tv-sub font-semibold" style="color: var(--color-text-primary);">Video Informasi</span>
                </div> -->
                <div wire:poll.15s
                    class="flex-1 mx-[clamp(0.6rem,1vw,1.25rem)] mb-[clamp(0.5rem,0.8vh,0.75rem)] video-frame">
                    <iframe class="w-full h-full" src="{{ $embedUrl }}?autoplay=1&mute=1" title="YouTube video"
                        frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen>
                    </iframe>
                </div>
            </section>

            {{-- BERITA TERBARU --}}
            <section class="panel flex flex-col min-h-0 overflow-hidden">
                <header
                    class="flex items-center gap-2 px-[clamp(0.6rem,1vw,1.25rem)] pt-[clamp(0.5rem,0.8vh,0.75rem)] pb-[clamp(0.3rem,0.5vh,0.5rem)] flex-shrink-0">
                    <div class="section-icon" style="background: var(--color-accent-soft);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="var(--color-accent)">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="tv-heading">{{ $post->title ?? 'Berita Terbaru' }}</span>
                        <div class="live-dot"></div>
                    </div>
                </header>

                {{-- Data Rows --}}
                <div class="mt-[clamp(0.25rem,0.4vh,0.4rem)] flex-1 scroll-container px-[clamp(0.6rem,1vw,1.25rem)] pb-[clamp(0.4rem,0.6vh,0.6rem)]"
                    data-autoscroll="true" data-speed="30" data-pause="3000">
                    <div class="scroll-track" style="color: var(--color-text-primary);">
                        @if($post)
                            <div class="prose max-w-none p-4">
                                {!! $post->body !!}
                            </div>
                        @else
                            <p class="text-center py-6 tv-cell" style="color: var(--color-text-muted);">Belum ada berita</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="grid grid-rows-1 gap-[clamp(0.5rem,1vw,1rem)] min-h-0">

            {{-- GALLERY --}}
            <section class="panel flex flex-col min-h-0 overflow-hidden relative">
                <header
                    class="flex items-center gap-2 px-[clamp(0.6rem,1vw,1.25rem)] pt-[clamp(0.5rem,0.8vh,0.75rem)] pb-[clamp(0.3rem,0.5vh,0.5rem)] flex-shrink-0 z-10 absolute top-0 left-0 w-full bg-gradient-to-b from-black/50 to-transparent">
                    <div class="section-icon" style="background: var(--color-warning-soft);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="var(--color-warning)">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="tv-heading text-white">Galeri</span>
                    </div>
                </header>

                <div class="flex-1 w-full h-full relative" x-data="{
                        activeSlide: 0,
                        slides: [
                            @foreach($galleries as $gallery)
                                '{{ Storage::url($gallery->url) }}',
                            @endforeach
                        ],
                        init() {
                            if (this.slides.length > 0) {
                                setInterval(() => {
                                    this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                                }, 5000);
                            }
                        }
                    }">
                    <template x-if="slides.length > 0">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div x-show="activeSlide === index"
                                 x-transition:enter="transition ease-out duration-1000"
                                 x-transition:enter-start="opacity-0 transform scale-105"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-1000"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute inset-0 w-full h-full">
                                <img :src="slide" class="w-full h-full" alt="Gallery Image">
                            </div>
                        </template>
                    </template>
                    <template x-if="slides.length === 0">
                        <div class="flex items-center justify-center w-full h-full" style="background: var(--color-bg-secondary);">
                            <p class="text-center py-6 tv-cell" style="color: var(--color-text-muted);">Belum ada galeri</p>
                        </div>
                    </template>
                </div>
            </section>
        </div>
    </main>

    {{-- ===== FOOTER RUNNING TEXT ===== --}}
    <footer class="footer-bar flex-shrink-0 px-[clamp(1rem,2vw,2rem)] py-[clamp(0.4rem,0.7vh,0.7rem)] overflow-hidden">
        <div class="ticker text-center tv-sub font-medium" style="color: var(--color-text-secondary);">
            <span>{{ $data[0]->running_text ?? 'Selamat datang di Fakultas Hukum Universitas Doktor Husni Ingratubun
                Papua — Tetap semangat berkarya! — Jadwal terbaru ujian proposal dan skripsi dapat dilihat pada papan
                informasi ini —' }}</span>
        </div>
    </footer>
</div>
