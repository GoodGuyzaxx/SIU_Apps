<div class="min-h-dvh bg-neutral-50 flex flex-col">
    {{-- Header --}}
    <header class="px-4 py-3 bg-white border-b sticky top-0 z-10">
        <h1 class="text-lg font-semibold">Mobile Broadcast</h1>
        <p class="text-xs text-neutral-500">Kirim URL YouTube & Running Text</p>
    </header>

    {{-- Konten --}}
    <main class="flex-1 p-4 space-y-4">
        <form wire:submit.prevent="save" class="space-y-4">
            <div class="space-y-1">
                <label class="text-sm font-medium">URL YouTube</label>
                <input
                    wire:model.lazy="yt_url"
                    type="url"
                    inputmode="url"
                    placeholder="https://youtu.be/xxxxx atau https://youtube.com/watch?v=xxxxx"
                    class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                @error('yt_url') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium">Running Text</label>
                <textarea
                    wire:model.defer="running_text"
                    rows="3"
                    placeholder="Tulis teks berjalan di sini..."
                    class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('running_text') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-blue-600 text-white py-2.5 text-sm font-semibold active:scale-[0.99]">
                Simpan
            </button>

            <div id="toast-root" class="fixed bottom-4 inset-x-0 z-50 px-4 pointer-events-none"></div>

            <div
                x-data
                x-on:saved.window="
                    clearTimeout(window.__toast);
                    const el = $refs.toast; el.classList.remove('hidden');
                    window.__toast = setTimeout(()=>el.classList.add('hidden'), 2000);
                ">

            </div>
        </form>

{{--        --}}{{-- Preview / Tampilan --}}
{{--        <section class="space-y-3">--}}
{{--            <div class="aspect-video w-full rounded-xl bg-black overflow-hidden">--}}
{{--                @if ($this->embedUrl)--}}
{{--                    <iframe--}}
{{--                        class="w-full h-full"--}}
{{--                        src="{{ $this->embedUrl }}"--}}
{{--                        title="YouTube"--}}
{{--                        frameborder="0"--}}
{{--                        allow="autoplay; encrypted-media; picture-in-picture"--}}
{{--                        allowfullscreen>--}}
{{--                    </iframe>--}}
{{--                @else--}}
{{--                    <div class="w-full h-full grid place-items-center text-white/70 text-xs">--}}
{{--                        Tempel URL YouTube untuk menampilkan video--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}

{{--            --}}{{-- Running Text --}}
{{--            <div class="w-full h-10 rounded-xl bg-white border overflow-hidden relative">--}}
{{--                @if ($running_text)--}}
{{--                    <div class="absolute inset-0 flex items-center">--}}
{{--                        <div class="whitespace-nowrap animate-marquee px-4 text-sm font-medium">--}}
{{--                            {{ $running_text }}--}}
{{--                        </div>--}}
{{--                        <div class="whitespace-nowrap animate-marquee px-4 text-sm font-medium" aria-hidden="true">--}}
{{--                            {{ $running_text }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <div class="w-full h-full grid place-items-center text-neutral-400 text-xs">--}}
{{--                        Isi teks untuk berjalan di sini--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </section>--}}
    </main>

    {{-- Footer tipis untuk mobile spacing --}}
    <footer class="h-4"></footer>

    {{-- style marquee sederhana --}}
    <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            animation: marquee 15s linear infinite;
        }
    </style>
</div>
