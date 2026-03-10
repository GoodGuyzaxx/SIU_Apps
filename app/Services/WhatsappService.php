<?php

namespace App\Services;

use App\Models\AccKesiapanUjian;
use App\Models\Dosen;
use App\Models\StatusUndangan;
use App\Models\Undangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Kirim pesan WA menggunakan GoWA API.
     *
     * @param string $phone Nomor HP tujuan (format: 628xxx)
     * @param string $message Isi pesan
     * @param string|null $link URL link (opsional)
     * @return bool
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

            // Format nomor telepon: pastikan format 628xxx@s.whatsapp.net
            $formattedPhone = $this->formatPhoneNumber($phone);

            // GoWA API mewajibkan field 'link' untuk link preview di WhatsApp.
            // Gunakan link yang diberikan, atau APP_URL jika publik,
            // atau fallback ke URL default jika masih localhost.
            $linkUrl = $link ?: config('app.url ');

            // Jika URL masih localhost, gunakan fallback URL publik
            if (str_contains($linkUrl, 'localhost') || str_contains($linkUrl, '127.0.0.1')) {
                $linkUrl = config('app.url');
                if (str_contains($linkUrl, 'localhost') || str_contains($linkUrl, '127.0.0.1')) {
                    $linkUrl = 'https://uningrat.ac.id';
                }
            }

            $payload = [
                'phone' => $formattedPhone,
                'link' => $linkUrl,
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

        }
        catch (\Exception $e) {
            Log::error('WhatsApp service error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim permintaan ACC kesiapan ujian ke Penguji 1.
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

        $message = "📋 *PERMINTAAN ACC KESIAPAN UJIAN*\n\n"
            . "Yth. Bapak/Ibu *{$dosen->nama}*,\n\n"
            . "Mohon memberikan persetujuan (ACC) kesiapan hadir sebagai *Penguji 1* pada ujian berikut:\n\n"
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

              Log::warning('Info URL', [
                'url' => $accUrl
            ]);

        return $this->sendMessage($dosen->nomor_hp, $message, $accUrl);
    }

    /**
     * Kirim notifikasi undangan ke semua dosen setelah ACC disetujui.
     */
    public function sendUndanganNotification(Undangan $undangan): void
    {
        $judul = $undangan->judul;
        $mahasiswa = $judul->mahasiswa;

        $tanggal = Carbon::createFromFormat('Y-m-d', $undangan->tanggal_hari)->format('d/m/Y');
        $waktu = Carbon::parse($undangan->waktu)->format('H:i');

        // Ambil semua status undangan (semua dosen yang terlibat)
        $statusList = StatusUndangan::where('id_undangan', $undangan->id)->get();

        foreach ($statusList as $status) {
            $dosen = $status->dosen;
            if (!$dosen || !$dosen->nomor_hp) {
                continue;
            }

            $roleLabel = match ($status->role) {
                    'pembimbing_satu' => 'Pembimbing 1',
                    'pembimbing_dua' => 'Pembimbing 2',
                    'penguji_satu' => 'Penguji 1',
                    'penguji_dua' => 'Penguji 2',
                    default => $status->role,
                };

            $message = "📩 *UNDANGAN UJIAN*\n\n"
                . "Yth. Bapak/Ibu *{$dosen->nama}*,\n\n"
                . "Mohon kesediaan hadir sebagai *{$roleLabel}* pada ujian berikut:\n\n"
                . "📝 *Perihal:* {$undangan->perihal}\n"
                . "👤 *Mahasiswa:* {$mahasiswa->nama} ({$mahasiswa->npm})\n"
                . "📖 *Judul:* {$judul->judul}\n"
                . "📅 *Tanggal:* {$tanggal}\n"
                . "⏰ *Waktu:* {$waktu} WIT\n"
                . "📍 *Tempat:* {$undangan->tempat}\n\n"
                . "Mohon segera konfirmasi kehadiran melalui Sistem Akademik.\n\n"
                . "Terima kasih.\n"
                . "_Sistem Akademik Uningrat Papua_";

            $this->sendMessage($dosen->nomor_hp, $message);
        }
    }

    /**
     * Kirim notifikasi ACC ditolak ke Admin.
     */
    public function sendAccRejectedNotification(AccKesiapanUjian $acc): bool
    {
        $undangan = $acc->undangan;
        $dosen = $acc->dosen;
        $judul = $undangan->judul;
        $mahasiswa = $judul->mahasiswa;

        // Kirim ke admin/kaprodi - Anda bisa sesuaikan nomor HP admin
        $message = "⚠️ *ACC KESIAPAN UJIAN DITOLAK*\n\n"
            . "Penguji 1 (*{$dosen->nama}*) menolak ACC kesiapan ujian:\n\n"
            . "👤 *Mahasiswa:* {$mahasiswa->nama} ({$mahasiswa->npm})\n"
            . "📖 *Judul:* {$judul->judul}\n"
            . "📅 *Tanggal:* {$undangan->tanggal_hari}\n\n"
            . "❌ *Alasan:* {$acc->alasan_penolakan}\n\n"
            . "Mohon segera menindaklanjuti penjadwalan ulang.\n\n"
            . "_Sistem Akademik Uningrat Papua_";

        // Log the rejection - admin notification can be sent if admin phone is configured
        Log::info('ACC Kesiapan Ujian ditolak', [
            'undangan_id' => $undangan->id,
            'dosen' => $dosen->nama,
            'alasan' => $acc->alasan_penolakan,
        ]);

        return true;
    }

    /**
     * Format nomor telepon ke format WhatsApp.
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Hapus spasi, strip, dll
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 0, ganti dengan 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Jika belum diawali 62, tambahkan
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone . '@s.whatsapp.net';
    }
}