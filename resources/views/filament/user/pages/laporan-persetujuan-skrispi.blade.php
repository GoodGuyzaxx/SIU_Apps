<x-filament-panels::page>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <!-- Informasi Judul Section -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-lg rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    @svg('heroicon-o-document-text', 'h-6 w-6 text-primary-600 dark:text-primary-400 mr-3')
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Informasi Judul
                    </h3>
                </div>
                <div class="space-y-5">
                    <div class="bg-white dark:bg-gray-800/50 rounded-lg p-4 border-l-4 border-primary-500">
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul Skripsi / Tugas Akhir</label>
                        <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white leading-relaxed">{{ $record->judul }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Pengajuan</label>
                        <p class="mt-2">
                            @if($record->jenis == 'Skripsi')
                                <span class="inline-flex items-center px-4 py-2 text-sm font-bold text-green-700 bg-gradient-to-r from-green-100 to-green-200 dark:from-green-800 dark:to-green-900 dark:text-green-100 rounded-lg shadow-sm">
                                    @svg('heroicon-m-academic-cap', 'h-5 w-5 mr-2')
                                    {{ $record->jenis }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 text-sm font-bold text-blue-700 bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-800 dark:to-blue-900 dark:text-blue-100 rounded-lg shadow-sm">
                                    @svg('heroicon-m-document-text', 'h-5 w-5 mr-2')
                                    {{ $record->jenis }}
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dosen Section -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-lg rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    @svg('heroicon-o-user-group', 'h-6 w-6 text-primary-600 dark:text-primary-400 mr-3')
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Dosen Pembimbing & Penguji
                    </h3>
                </div>

                <!-- Pembimbing -->
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-primary-300 to-transparent dark:via-primary-700"></div>
                        <span class="px-3 text-sm font-semibold text-primary-600 dark:text-primary-400">PEMBIMBING</span>
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-primary-300 to-transparent dark:via-primary-700"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md">
                                    1
                                </div>
                                <div class="ml-3 flex-1">
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pembimbing I</label>
                                    <p class="mt-1 text-base font-medium text-gray-900 dark:text-white">{{ $record->pembimbing_satu ?? 'Belum ditentukan' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md">
                                    2
                                </div>
                                <div class="ml-3 flex-1">
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pembimbing II</label>
                                    <p class="mt-1 text-base font-medium text-gray-900 dark:text-white">{{ $record->pembimbing_dua ?? 'Belum ditentukan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Penguji -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-orange-300 to-transparent dark:via-orange-700"></div>
                        <span class="px-3 text-sm font-semibold text-orange-600 dark:text-orange-400">PENGUJI</span>
                        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-orange-300 to-transparent dark:via-orange-700"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-orange-300 dark:hover:border-orange-700 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md">
                                    1
                                </div>
                                <div class="ml-3 flex-1">
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penguji I</label>
                                    <p class="mt-1 text-base font-medium text-gray-900 dark:text-white">{{ $record->penguji_satu ?? 'Belum ditentukan' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-orange-300 dark:hover:border-orange-700 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center text-white font-bold shadow-md">
                                    2
                                </div>
                                <div class="ml-3 flex-1">
                                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penguji II</label>
                                    <p class="mt-1 text-base font-medium text-gray-900 dark:text-white">{{ $record->penguji_dua ?? 'Belum ditentukan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Data Mahasiswa -->
            <div class="bg-gradient-to-br from-primary-50 to-white dark:from-gray-800 dark:to-gray-900 shadow-lg rounded-2xl p-6 border border-primary-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    @svg('heroicon-o-user-circle', 'h-6 w-6 text-primary-600 dark:text-primary-400 mr-3')
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Data Mahasiswa
                    </h3>
                </div>
                <div class="space-y-5">
                    <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-primary-200 dark:border-gray-700">
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Mahasiswa</label>
                        <p class="mt-2 text-lg font-bold text-gray-900 dark:text-white">{{ $record->mahasiswa->nama }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-primary-200 dark:border-gray-700">
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">NPM</label>
                        <p class="mt-2 text-base font-mono font-semibold text-primary-600 dark:text-primary-400">{{ $record->mahasiswa->npm }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-primary-200 dark:border-gray-700">
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nomor HP</label>
                        <p class="mt-2 text-base font-medium text-gray-900 dark:text-white flex items-center">
                            @svg('heroicon-m-phone', 'h-5 w-5 text-green-500 mr-2')
                            <span>{{ $record->mahasiswa->nomor_hp }}</span>
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border border-primary-200 dark:border-gray-700">
                        <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Agama</label>
                        <p class="mt-2 text-base font-medium text-gray-900 dark:text-white">{{ $record->mahasiswa->agama }}</p>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-gradient-to-br from-white to-purple-50 dark:from-gray-800 dark:to-gray-900 shadow-lg rounded-2xl p-6 border border-purple-100 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    @svg('heroicon-o-clock', 'h-6 w-6 text-purple-600 dark:text-purple-400 mr-3')
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Status
                    </h3>
                </div>
                <div class="space-y-5">
                    <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border-l-4 border-green-500">
                        <div class="flex items-center">
                            @svg('heroicon-m-calendar', 'h-5 w-5 text-green-500 mr-2')
                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Pengajuan</label>
                        </div>
                        <p class="mt-2 text-base font-semibold text-gray-900 dark:text-white">{{ $record->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800/50 rounded-xl p-4 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            @svg('heroicon-m-arrow-path', 'h-5 w-5 text-blue-500 mr-2')
                            <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Terakhir Diperbarui</label>
                        </div>
                        <p class="mt-2 text-base font-semibold text-gray-900 dark:text-white">{{ $record->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</x-filament-panels::page>
