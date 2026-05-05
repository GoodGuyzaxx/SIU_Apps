<?php

namespace App\Filament\Widgets;

use App\Models\AccKesiapanUjian;
use App\Models\Dosen;
use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\SuratKeputusan;
use App\Models\Undangan;
use App\Models\UsulanJudul;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsDashboard extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getDescription(): string
    {
        $user = Auth::user();
        $name = $user?->name ?? 'Admin';
        $now  = now()->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm');

        return "👋 Selamat datang, {$name} — {$now}";
    }

    protected function getStats(): array
    {
        $prodiId = (isset($this->filters['prodi_id']) && $this->filters['prodi_id']) ? (int) $this->filters['prodi_id'] : null;

        // ── Akademik ──────────────────────────────────────────────
        $countPengajuan = UsulanJudul::where('status', 'Pengajuan')
            ->when($prodiId, fn ($q) => $q->whereHas('mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)))
            ->count();

        $countPengajuanDiproses = UsulanJudul::whereNotIn('status', ['Pengajuan', 'Ditolak'])
            ->when($prodiId, fn ($q) => $q->whereHas('mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)))
            ->count();

        $countProposal = Judul::where('status', 'proposal')
            ->when($prodiId, fn ($q) => $q->whereHas('mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)))
            ->count();

        $countSkripsi = Judul::where('status', 'hasil')
            ->when($prodiId, fn ($q) => $q->whereHas('mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)))
            ->count();

        $totalJudul = Judul::when($prodiId, fn ($q) => $q->whereHas('mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)))
            ->count();

        // ── Undangan & ACC ────────────────────────────────────────
        $countUndangan = Undangan::when($prodiId, fn ($q) => $q->whereHas(
            'judul.mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)
        ))->count();

        $countUndanganHariIni = Undangan::whereDate('tanggal_hari', today())
            ->when($prodiId, fn ($q) => $q->whereHas(
                'judul.mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)
            ))->count();

        $accScope = fn ($q) => $q->when($prodiId, fn ($q) => $q->whereHas(
            'undangan.judul.mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)
        ));

        $countAccPending   = AccKesiapanUjian::where('status', 'pending')->tap($accScope)->count();
        $countAccDisetujui = AccKesiapanUjian::where('status', 'disetujui')->tap($accScope)->count();
        $countAccDitolak   = AccKesiapanUjian::where('status', 'ditolak')->tap($accScope)->count();

        $countSkMahasiswa = SuratKeputusan::when($prodiId, fn ($q) => $q->whereHas(
            'judul.mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId)
        ))->count();

        // ── Data Master ───────────────────────────────────────────
        $countMahasiswa = Mahasiswa::when($prodiId, fn ($q) => $q->where('prodi_id', $prodiId))->count();
        $countDosen     = Dosen::count();

        return [
            // ── Baris 1: Pengajuan Judul ──────────────────────────
            Stat::make('Pengajuan Menunggu', $countPengajuan)
                ->description('Usulan judul belum diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-document-text')
                ->color('warning'),

            Stat::make('Pengajuan Diproses', $countPengajuanDiproses)
                ->description('Sudah melewati seleksi awal')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->icon('heroicon-o-document-check')
                ->color('info'),

            Stat::make('Total Judul Terdaftar', $totalJudul)
                ->description("Proposal: {$countProposal} · Skripsi: {$countSkripsi}")
                ->descriptionIcon('heroicon-m-academic-cap')
                ->icon('heroicon-o-book-open')
                ->color('success'),

            // ── Baris 2: Undangan & ACC ───────────────────────────
            Stat::make('Total Undangan Ujian', $countUndangan)
                ->description("Hari ini: {$countUndanganHariIni} undangan")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->icon('heroicon-o-envelope')
                ->color('primary'),

            Stat::make('ACC Menunggu Konfirmasi', $countAccPending)
                ->description("Disetujui: {$countAccDisetujui} · Ditolak: {$countAccDitolak}")
                ->descriptionIcon('heroicon-m-bell-alert')
                ->icon('heroicon-o-check-badge')
                ->color($countAccPending > 0 ? 'danger' : 'success'),

            Stat::make('SK Mahasiswa', $countSkMahasiswa)
                ->description('Surat keputusan mahasiswa yang sudah terbit')
                ->descriptionIcon('heroicon-m-document-text')
                ->icon('heroicon-o-document-check')
                ->color('success'),

            // ── Baris 3: Data Master ──────────────────────────────
            Stat::make('Total Mahasiswa', $countMahasiswa)
                ->description('Terdaftar di sistem')
                ->descriptionIcon('heroicon-m-users')
                ->icon('heroicon-o-user-group')
                ->color('gray'),

            Stat::make('Total Dosen', $countDosen)
                ->description('Aktif di sistem')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->icon('heroicon-o-identification')
                ->color('gray'),
        ];
    }
}
