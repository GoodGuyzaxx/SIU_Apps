<?php

namespace App\Services;

use App\Models\AccKesiapanUjian;
use App\Models\Dosen;
use App\Models\Undangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Kirim pesan WA menggunakan GoWA API.
     */
    public function sendMessage(string $phone, string $message, ?string $link = null): bool
    {
        try {
            // Validasi nomor HP minimal
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($cleanPhone) < 10) {
                Log::warning('WhatsApp: Nomor HP terlalu pendek, pesan tidak dikirim', [
                    'phone' => $phone,
                ]);
                return false;
            }

            // Format nomor telepon
            $formattedPhone = $this->formatPhoneNumber($phone);

            // GoWA API mewajibkan field 'link' untuk link preview
            $linkUrl = $link ?: config('app.url');

            // Jika URL masih localhost, gunakan fallback URL publik
            if (str_contains($linkUrl, 'localhost') || str_contains($linkUrl, '127.0.0.1')) {
                $linkUrl = config('app.url');
                if (str_contains($linkUrl, 'localhost') || str_contains($linkUrl, '127.0.0.1')) {
                    $linkUrl = 'https://uningrat.ac.id';
                }
            }

            $payload = [
                'phone' => $formattedPhone,
                'link'  => $linkUrl,
                'caption' => $message,
            ];

            $response = Http::withBasicAuth(
                config('gowaapi.user'),
                config('gowaapi.pass')
            )
                ->withHeaders([
                    'Accept' => 'application/json',
                    'X-Device-Id' => config('gowaapi.device'),
                ])
                ->post(config('gowaapi.url'), $payload);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'phone' => $formattedPhone,
                ]);
                return true;
            }

            Log::error('WhatsApp message failed', [
                'phone' => $formattedPhone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp service error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim permintaan ACC kesiapan ujian ke dosen.
     */
    public function sendAccKesiapanRequest(AccKesiapanUjian $acc): bool
    {
        $undangan = $acc->undangan;
        $dosen = $acc->dosen;
        $judul = $undangan->judul;
        $mahasiswa = $judul->mahasiswa;

        $accUrl = route('acc.kesiapan.form', ['token' => $acc->token]);

        $tanggal = Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->format('d/m/Y');
        $waktu = Carbon::parse($undangan->waktu)->format('H:i');

        // Label role sesuai data ACC
        $roleLabel = $this->getRoleLabel($acc->role);

        $message = "📋 *PERMINTAAN ACC KESIAPAN UJIAN*\n\n"
            . "Yth. Bapak/Ibu *{$dosen->nama}*,\n\n"
            . "Mohon memberikan persetujuan (ACC) kesiapan hadir sebagai *{$roleLabel}* pada ujian berikut:\n\n"
            . "📝 *Perihal:* {$undangan->perihal}\n"
            . "👤 *Mahasiswa:* {$mahasiswa->nama} ({$mahasiswa->npm})\n"
            . "📖 *Judul:* {$judul->judul}\n"
            . "📅 *Tanggal:* {$tanggal}\n"
            . "⏰ *Waktu:* {$waktu} WIT\n"
            . "📍 *Tempat:* {$undangan->tempat}\n\n"
            . "Silakan klik link berikut untuk memberikan ACC:\n"
            . "{$accUrl}\n\n"
            . "Terima kasih.\n"
            . "_Sistem Akademik Uningrat Papua_";

        return $this->sendMessage($dosen->nomor_hp, $message, $accUrl);
    }

    /**
     * Kirim notifikasi ACC ditolak (log only).
     */
    public function sendAccRejectedNotification(AccKesiapanUjian $acc): bool
    {
        $undangan = $acc->undangan;
        $dosen = $acc->dosen;
        $roleLabel = $this->getRoleLabel($acc->role);

        Log::info('ACC Kesiapan Ujian ditolak', [
            'undangan_id' => $undangan->id,
            'dosen' => $dosen->nama,
            'role' => $roleLabel,
            'alasan' => $acc->alasan_penolakan,
        ]);

        return true;
    }

    /**
     * Kirim notifikasi WA ke mahasiswa untuk upload softcopy / draft skripsi.
     */
    public function sendSoftcopyRequestToMahasiswa(Undangan $undangan): bool
    {
        $judul     = $undangan->judul;
        $mahasiswa = $judul?->mahasiswa;

        if (!$mahasiswa) {
            Log::warning('WhatsApp sendSoftcopyRequest: mahasiswa tidak ditemukan', [
                'undangan_id' => $undangan->id,
            ]);
            return false;
        }

        if (!$mahasiswa->nomor_hp) {
            Log::warning('WhatsApp sendSoftcopyRequest: nomor HP mahasiswa kosong', [
                'mahasiswa' => $mahasiswa->nama,
                'npm'       => $mahasiswa->npm,
            ]);
            return false;
        }

        $tanggal = Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->format('d/m/Y');
        $waktu   = Carbon::parse($undangan->waktu)->format('H:i');

        $message = "📢 *PEMBERITAHUAN UPLOAD DRAFT SKRIPSI*\n\n"
            . "Yth. *{$mahasiswa->nama}* ({$mahasiswa->npm}),\n\n"
            . "Undangan ujian Anda telah dibuat. Sebelum ujian berlangsung, "
            . "Anda *diwajibkan mengunggah softcopy / draft* skripsi Anda melalui sistem akademik.\n\n"
            . "📝 *Perihal:* {$undangan->perihal}\n"
            . "📖 *Judul:* {$judul->judul}\n"
            . "📅 *Tanggal Ujian:* {$tanggal}\n"
            . "⏰ *Waktu:* {$waktu} WIT\n"
            . "📍 *Tempat:* {$undangan->tempat}\n\n"
            . "Silakan login ke sistem akademik dan unggah softcopy dokumen Anda "
            . "sebelum tanggal ujian.\n\n"
            . "Terima kasih.\n"
            . "_Sistem Akademik Uningrat Papua_";

        $appUrl = config('app.url');
        if (str_contains($appUrl, 'localhost') || str_contains($appUrl, '127.0.0.1')) {
            $appUrl = 'https://uningrat.ac.id';
        }

        $result = $this->sendMessage($mahasiswa->nomor_hp, $message, $appUrl);

        if ($result) {
            Log::info('WhatsApp: Notifikasi upload softcopy terkirim ke mahasiswa', [
                'mahasiswa'   => $mahasiswa->nama,
                'npm'         => $mahasiswa->npm,
                'undangan_id' => $undangan->id,
            ]);
        }

        return $result;
    }

    /**
     * Cek apakah syarat minimum dosen terpenuhi untuk undangan.
     *
     * Aturan:
     * - Minimal 1 Pembimbing + 1 Penguji = ✅
     * - 0 Pembimbing + berapapun Penguji = ❌
     */
    public static function checkMinimumRequirements(int $undanganId): array
    {
        $accRecords = AccKesiapanUjian::where('id_undangan', $undanganId)->get();

        $pembimbingDisetujui = $accRecords->filter(function ($acc) {
            return str_contains($acc->role, 'pembimbing') && $acc->status === 'disetujui';
        })->count();

        $pengujiDisetujui = $accRecords->filter(function ($acc) {
            return str_contains($acc->role, 'penguji') && $acc->status === 'disetujui';
        })->count();

        // Cek apakah masih mungkin terpenuhi (tidak semua ditolak)
        $pembimbingPending = $accRecords->filter(function ($acc) {
            return str_contains($acc->role, 'pembimbing') && $acc->status === 'pending';
        })->count();

        $pengujiPending = $accRecords->filter(function ($acc) {
            return str_contains($acc->role, 'penguji') && $acc->status === 'pending';
        })->count();

        $terpenuhi = $pembimbingDisetujui >= 1 && $pengujiDisetujui >= 1;

        // Tidak mungkin terpenuhi jika semua pembimbing/penguji sudah menolak
        $tidakMungkin = ($pembimbingDisetujui === 0 && $pembimbingPending === 0)
            || ($pengujiDisetujui === 0 && $pengujiPending === 0);

        return [
            'terpenuhi' => $terpenuhi,
            'tidak_mungkin' => $tidakMungkin,
            'pembimbing_setuju' => $pembimbingDisetujui,
            'penguji_setuju' => $pengujiDisetujui,
            'pembimbing_pending' => $pembimbingPending,
            'penguji_pending' => $pengujiPending,
        ];
    }

    /**
     * Label role yang readable.
     */
    public static function getRoleLabel(?string $role): string
    {
        return match ($role) {
            'pembimbing_satu' => 'Pembimbing 1',
            'pembimbing_dua' => 'Pembimbing 2',
            'penguji_satu' => 'Penguji 1',
            'penguji_dua' => 'Penguji 2',
            default => $role ?? '-',
        };
    }

    /**
     * Format nomor telepon ke format WhatsApp.
     */
    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone . '@s.whatsapp.net';
    }
}