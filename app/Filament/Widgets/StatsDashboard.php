<?php

namespace App\Filament\Widgets;

use App\Models\AccKesiapanUjian;
use App\Models\Dosen;
use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\Undangan;
use App\Models\UsulanJudul;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsDashboard extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getDescription(): string
    {
        $user = Auth::user();
        $name = $user?->name ?? 'Admin';
        $now  = now()->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm');

        return "👋 Selamat datang, **{$name}** — {$now}";
    }

    protected function getStats(): array
    {
        // ── Akademik ──────────────────────────────────────────────
        $countPengajuan         = UsulanJudul::where('status', 'Pengajuan')->count();
        $countPengajuanDiproses = UsulanJudul::whereNotIn('status', ['Pengajuan', 'Ditolak'])->count();

        $countProposal = Judul::where('status', 'proposal')->count();
        $countSkripsi  = Judul::where('status', 'hasil')->count();
        $totalJudul    = Judul::count();

        // ── Undangan & ACC ────────────────────────────────────────
        $countUndangan        = Undangan::count();
        $countUndanganHariIni = Undangan::whereDate('tanggal_hari', today())->count();
        $countAccPending      = AccKesiapanUjian::where('status', 'pending')->count();
        $countAccDisetujui    = AccKesiapanUjian::where('status', 'disetujui')->count();
        $countAccDitolak      = AccKesiapanUjian::where('status', 'ditolak')->count();

        // ── Data Master ───────────────────────────────────────────
        $countMahasiswa = Mahasiswa::count();
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
