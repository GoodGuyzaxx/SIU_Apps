<x-filament-panels::page>

    <!-- Header Section dengan Breadcrumb Visual -->
{{--    <div class="mb-8">--}}
{{--        <div class="flex items-center justify-between">--}}
{{--            <div>--}}
{{--                <p class="text-gray-600 dark:text-gray-400">Informasi lengkap pengajuan skripsi/tugas akhir</p>--}}
{{--            </div>--}}
{{--            <div class="flex gap-3">--}}
{{--                <button class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">--}}
{{--                    @svg('heroicon-o-printer', 'h-5 w-5 mr-2 text-gray-600 dark:text-gray-400')--}}
{{--                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Cetak</span>--}}
{{--                </button>--}}
{{--                <button class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors shadow-lg shadow-primary-500/30">--}}
{{--                    @svg('heroicon-o-pencil', 'h-5 w-5 mr-2')--}}
{{--                    <span class="text-sm font-medium">Edit</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Informasi Judul Section - Enhanced -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                            @svg('heroicon-o-document-text', 'h-6 w-6 text-white')
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Informasi Judul
                        </h3>
                    </div>
                </div>
                <div class="p-6 space-y-5">
                    <div class="group">
                        <label class="inline-flex items-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                            @svg('heroicon-m-document-text', 'h-4 w-4 mr-1.5')
                            Judul Skripsi / Tugas Akhir
                        </label>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 rounded-lg p-5 border-l-4 border-primary-500 group-hover:border-primary-600 transition-colors">
                            <p class="text-lg font-semibold text-gray-900 dark:text-white leading-relaxed">{{ $record->judul }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Pengajuan</label>
                        @if($record->jenis == 'Skripsi')
                            <span class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-green-700 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/50 dark:to-green-800/50 dark:text-green-100 rounded-xl shadow-sm border border-green-200 dark:border-green-800">
                                @svg('heroicon-m-academic-cap', 'h-5 w-5 mr-2')
                                {{ $record->jenis }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/50 dark:to-blue-800/50 dark:text-blue-100 rounded-xl shadow-sm border border-blue-200 dark:border-blue-800">
                                @svg('heroicon-m-document-text', 'h-5 w-5 mr-2')
                                {{ $record->jenis }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dosen Section - Enhanced -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                            @svg('heroicon-o-user-group', 'h-6 w-6 text-white')
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Dosen Pembimbing & Penguji
                        </h3>
                    </div>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Pembimbing -->
                    <div>
                        <div class="flex items-center mb-5">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                @svg('heroicon-m-user-circle', 'h-5 w-5 text-white')
                            </div>
                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Pembimbing</h4>
                            <div class="flex-1 h-px bg-gradient-to-r from-blue-200 to-transparent dark:from-blue-800 ml-3"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="group bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border border-blue-200 dark:border-blue-900 hover:border-blue-400 dark:hover:border-blue-700 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md group-hover:scale-110 transition-transform">
                                        1
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <label class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Pembimbing I</label>
                                        <p class="mt-2 text-base font-bold text-gray-900 dark:text-white">{{ $record->pembimbing_satu ?? 'Belum ditentukan' }}</p>
                                        @if($record->pembimbing_satu)
                                            <span class="inline-flex items-center mt-2 text-xs text-green-600 dark:text-green-400">
                                                @svg('heroicon-m-check-circle', 'h-4 w-4 mr-1')
                                                Sudah ditentukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center mt-2 text-xs text-gray-400 dark:text-gray-500">
                                                @svg('heroicon-m-clock', 'h-4 w-4 mr-1')
                                                Menunggu penetapan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="group bg-gradient-to-br from-purple-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border border-purple-200 dark:border-purple-900 hover:border-purple-400 dark:hover:border-purple-700 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md group-hover:scale-110 transition-transform">
                                        2
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <label class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Pembimbing II</label>
                                        <p class="mt-2 text-base font-bold text-gray-900 dark:text-white">{{ $record->pembimbing_dua ?? 'Belum ditentukan' }}</p>
                                        @if($record->pembimbing_dua)
                                            <span class="inline-flex items-center mt-2 text-xs text-green-600 dark:text-green-400">
                                                @svg('heroicon-m-check-circle', 'h-4 w-4 mr-1')
                                                Sudah ditentukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center mt-2 text-xs text-gray-400 dark:text-gray-500">
                                                @svg('heroicon-m-clock', 'h-4 w-4 mr-1')
                                                Menunggu penetapan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penguji -->
                    <div>
                        <div class="flex items-center mb-5">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                                @svg('heroicon-m-clipboard-document-check', 'h-5 w-5 text-white')
                            </div>
                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Penguji</h4>
                            <div class="flex-1 h-px bg-gradient-to-r from-orange-200 to-transparent dark:from-orange-800 ml-3"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="group bg-gradient-to-br from-orange-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border border-orange-200 dark:border-orange-900 hover:border-orange-400 dark:hover:border-orange-700 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md group-hover:scale-110 transition-transform">
                                        1
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <label class="text-xs font-semibold text-orange-600 dark:text-orange-400 uppercase tracking-wider">Penguji I</label>
                                        <p class="mt-2 text-base font-bold text-gray-900 dark:text-white">{{ $record->penguji_satu ?? 'Belum ditentukan' }}</p>
                                        @if($record->penguji_satu)
                                            <span class="inline-flex items-center mt-2 text-xs text-green-600 dark:text-green-400">
                                                @svg('heroicon-m-check-circle', 'h-4 w-4 mr-1')
                                                Sudah ditentukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center mt-2 text-xs text-gray-400 dark:text-gray-500">
                                                @svg('heroicon-m-clock', 'h-4 w-4 mr-1')
                                                Menunggu penetapan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="group bg-gradient-to-br from-red-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-5 border border-red-200 dark:border-red-900 hover:border-red-400 dark:hover:border-red-700 hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md group-hover:scale-110 transition-transform">
                                        2
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <label class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider">Penguji II</label>
                                        <p class="mt-2 text-base font-bold text-gray-900 dark:text-white">{{ $record->penguji_dua ?? 'Belum ditentukan' }}</p>
                                        @if($record->penguji_dua)
                                            <span class="inline-flex items-center mt-2 text-xs text-green-600 dark:text-green-400">
                                                @svg('heroicon-m-check-circle', 'h-4 w-4 mr-1')
                                                Sudah ditentukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center mt-2 text-xs text-gray-400 dark:text-gray-500">
                                                @svg('heroicon-m-clock', 'h-4 w-4 mr-1')
                                                Menunggu penetapan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Data Mahasiswa - Enhanced -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300 sticky top-6">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                            @svg('heroicon-o-user-circle', 'h-6 w-6 text-white')
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Data Mahasiswa
                        </h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-900">
                        <label class="flex items-center text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-2">
                            @svg('heroicon-m-user', 'h-4 w-4 mr-1.5')
                            Nama Mahasiswa
                        </label>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->mahasiswa->nama }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                        <label class="flex items-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">
                            @svg('heroicon-m-identification', 'h-4 w-4 mr-1.5')
                            NPM
                        </label>
                        <p class="text-base font-mono font-bold text-indigo-600 dark:text-indigo-400 tracking-wider">{{ $record->mahasiswa->npm }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-green-200 dark:border-green-900">
                        <label class="flex items-center text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider mb-2">
                            @svg('heroicon-m-phone', 'h-4 w-4 mr-1.5')
                            Nomor HP
                        </label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->nomor_hp }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-purple-200 dark:border-purple-900">
                        <label class="flex items-center text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-2">
                            @svg('heroicon-m-heart', 'h-4 w-4 mr-1.5')
                            Agama
                        </label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $record->mahasiswa->agama }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Timeline - Enhanced -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center mr-3">
                            @svg('heroicon-o-clock', 'h-6 w-6 text-white')
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Timeline
                        </h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="relative pl-8 pb-6 border-l-2 border-emerald-200 dark:border-emerald-800">
                        <div class="absolute -left-2 top-0 w-4 h-4 bg-emerald-500 rounded-full ring-4 ring-emerald-100 dark:ring-emerald-900"></div>
                        <label class="flex items-center text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-2">
                            @svg('heroicon-m-calendar', 'h-4 w-4 mr-1.5')
                            Tanggal Pengajuan
                        </label>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $record->created_at->format('H:i') }} WIB</p>
                    </div>
                    <div class="relative pl-8">
                        <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-500 rounded-full ring-4 ring-blue-100 dark:ring-blue-900 animate-pulse"></div>
                        <label class="flex items-center text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-2">
                            @svg('heroicon-m-arrow-path', 'h-4 w-4 mr-1.5')
                            Terakhir Diperbarui
                        </label>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $record->updated_at->diffForHumans() }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $record->updated_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</x-filament-panels::page>
