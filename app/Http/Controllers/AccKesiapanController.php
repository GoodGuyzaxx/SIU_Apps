<?php

namespace App\Http\Controllers;

use App\Models\AccKesiapanUjian;
use App\Models\Undangan;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccKesiapanController extends Controller
{
    /**
     * Tampilkan halaman ACC kesiapan ujian.
     */
    public function show(string $token)
    {
        $acc = AccKesiapanUjian::with(['undangan.judul.mahasiswa', 'dosen'])
            ->where('token', $token)
            ->firstOrFail();

        $undangan = $acc->undangan;

        return view('acc-kesiapan.form', compact('acc', 'undangan'));
    }

    /**
     * Proses persetujuan ACC.
     */
    public function setujui(string $token)
    {
        $acc = AccKesiapanUjian::with(['undangan.judul.mahasiswa', 'dosen'])
            ->where('token', $token)
            ->firstOrFail();

        if (!$acc->isPending()) {
            return redirect()->route('acc.kesiapan.form', ['token' => $token])
                ->with('error', 'ACC sudah direspon sebelumnya.');
        }

        $acc->update([
            'status' => 'disetujui',
            'responded_at' => Carbon::now(),
        ]);

        // Update status undangan ke "dijadwalkan"
        $undangan = $acc->undangan;
        $undangan->update(['status_ujian' => 'dijadwalkan']);

        // Kirim notifikasi undangan ke semua dosen via WhatsApp
        $waService = new WhatsappService();
        $waService->sendUndanganNotification($undangan);

        return redirect()->route('acc.kesiapan.form', ['token' => $token])
            ->with('success', 'Terima kasih! ACC kesiapan ujian telah disetujui. Undangan akan dikirim ke seluruh dosen.');
    }

    /**
     * Proses penolakan ACC.
     */
    public function tolak(Request $request, string $token)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $acc = AccKesiapanUjian::with(['undangan.judul.mahasiswa', 'dosen'])
            ->where('token', $token)
            ->firstOrFail();

        if (!$acc->isPending()) {
            return redirect()->route('acc.kesiapan.form', ['token' => $token])
                ->with('error', 'ACC sudah direspon sebelumnya.');
        }

        $acc->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'responded_at' => Carbon::now(),
        ]);

        // Update status undangan ke gagal
        $undangan = $acc->undangan;
        $undangan->update(['status_ujian' => 'gagal_menjadwalkan_ujian']);

        // Kirim notifikasi penolakan
        $waService = new WhatsappService();
        $waService->sendAccRejectedNotification($acc);

        return redirect()->route('acc.kesiapan.form', ['token' => $token])
            ->with('success', 'ACC kesiapan ujian telah ditolak. Admin akan segera menindaklanjuti.');
    }
}