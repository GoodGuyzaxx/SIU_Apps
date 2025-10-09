<x-filament-panels::page>
    @if($mahasiswa)
        {{-- Profile Header Card --}}
        {{--        <x-filament::section>--}}
        {{--            <div class="flex items-center gap-4">--}}
        {{--                <div class="flex-shrink-0">--}}
        {{--                    <x-filament::avatar--}}
        {{--                        size="xl"--}}
        {{--                        :src="null"--}}
        {{--                    >--}}
        {{--                        {{ strtoupper(substr($mahasiswa->nama, 0, 2)) }}--}}
        {{--                    </x-filament::avatar>--}}
        {{--                </div>--}}
        {{--                <div>--}}
        {{--                    <h2 class="text-2xl font-bold">--}}
        {{--                        {{ $mahasiswa->nama }}--}}
        {{--                    </h2>--}}
        {{--                    <p class="text-sm text-gray-500 dark:text-gray-400">--}}
        {{--                        NPM: {{ $mahasiswa->npm }}--}}
        {{--                    </p>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </x-filament::section>--}}

        {{-- Profile Details Card --}}
        <x-filament::section>
            <x-slot name="heading">
                Informasi Detail
            </x-slot>

            <div class="space-y-4">
                {{-- Nama --}}
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"

                            disabled
                            :value="$mahasiswa->nama"
                        >
                            <x-slot name="prefix">
                                <x-filament::icon
                                    icon="heroicon-m-user"
                                    class="h-5 w-5"
                                />
                            </x-slot>
                        </x-filament::input>
                    </x-filament::input.wrapper>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                </div>

                {{-- NPM --}}
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            disabled
                            :value="$mahasiswa->npm"
                        >
                            <x-slot name="prefix">
                                <x-filament::icon
                                    icon="heroicon-m-identification"
                                    class="h-5 w-5"
                                />
                            </x-slot>
                        </x-filament::input>
                    </x-filament::input.wrapper>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">NPM (Nomor Pokok Mahasiswa)</p>
                </div>

                {{-- Nomor HP --}}
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            disabled
                            :value="$mahasiswa->nomor_hp"
                        >
                            <x-slot name="prefix">
                                <x-filament::icon
                                    icon="heroicon-m-phone"
                                    class="h-5 w-5"
                                />
                            </x-slot>
                        </x-filament::input>
                    </x-filament::input.wrapper>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor HP</p>
                </div>

                {{-- Agama --}}
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            disabled
                            :value="$mahasiswa->agama"
                        >
                            <x-slot name="prefix">
                                <x-filament::icon
                                    icon="heroicon-m-sparkles"
                                    class="h-5 w-5"
                                />
                            </x-slot>
                        </x-filament::input>
                    </x-filament::input.wrapper>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Agama</p>
                </div>

                {{-- User Email --}}
                @if($mahasiswa->user)
                    <div>
                        <x-filament::input.wrapper>
                            <x-filament::input
                                type="email"
                                disabled
                                :value="$mahasiswa->user->email"
                            >
                                <x-slot name="prefix">
                                    <x-filament::icon
                                        icon="heroicon-m-envelope"
                                        class="h-5 w-5"
                                    />
                                </x-slot>
                            </x-filament::input>
                        </x-filament::input.wrapper>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Email</p>
                    </div>
                @endif

                {{-- Tanggal Dibuat --}}
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            disabled
                            :value="$mahasiswa->created_at->format('d F Y')"
                        >
                            <x-slot name="prefix">
                                <x-filament::icon
                                    icon="heroicon-m-calendar"
                                    class="h-5 w-5"
                                />
                            </x-slot>
                        </x-filament::input>
                    </x-filament::input.wrapper>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Terdaftar Sejak</p>
                </div>
            </div>
        </x-filament::section>
    @else
        {{-- No Data Warning --}}
        <x-filament::section
            icon="heroicon-o-exclamation-triangle">
            <x-slot name="heading">
                Silakan Lengkapi Data Terlebih Dahulu!!!
            </x-slot>
        </x-filament::section>
    @endif
</x-filament-panels::page>
