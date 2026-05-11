<div class="flex flex-col gap-4">
    <div class="flex justify-end">
        <a
            href="{{ $url }}"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-lg bg-success-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-success-500 focus:outline-none"
        >
            <x-heroicon-o-printer class="h-5 w-5" />
            Print / Unduh
        </a>
    </div>
    <iframe
        src="{{ $url }}"
        class="w-full rounded-lg border-0"
        style="height: 72vh;"
    ></iframe>
</div>
