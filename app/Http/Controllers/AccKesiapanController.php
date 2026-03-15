<?php

namespace App\Http\Controllers;

use App\Models\AccKesiapanUjian;
use App\Models\StatusUndangan;
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

        // Ambil semua ACC untuk undangan ini agar bisa tampilkan status dosen lain
        $allAcc = AccKesiapanUjian::with('dosen')
            ->where('id_undangan', $undangan->id)
            ->get();

        return view('acc-kesiapan.form', compact('acc', 'undangan', 'allAcc'));
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

        // Update ACC status
        $acc->update([
            'status' => 'disetujui',
            'responded_at' => Carbon::now(),
        ]);

        // Update juga StatusUndangan konfirmasi untuk dosen ini
        StatusUndangan::where('id_undangan', $acc->id_undangan)
            ->where('id_dosen', $acc->id_dosen)
            ->update([
                'status_konfirmasi' => 'Hadir',
                'confirmed_at' => Carbon::now(),
            ]);

        // Cek apakah syarat minimum terpenuhi
        $undangan = $acc->undangan;
        $check = WhatsappService::checkMinimumRequirements($undangan->id);

        if ($check['terpenuhi']) {
            // Cek apakah draft sudah diupload
            if (!empty($undangan->softcopy_file_path)) {
                $undangan->update(['status_ujian' => 'ready_to_exam']);
            } else {
                $undangan->update(['status_ujian' => 'dijadwalkan']);
            }
        }
        // Jika belum terpenuhi, tetap menunggu_acc

        $roleLabel = WhatsappService::getRoleLabel($acc->role);

        return redirect()->route('acc.kesiapan.form', ['token' => $token])
            ->with('success', "Terima kasih! Anda telah menyetujui hadir sebagai {$roleLabel}.");
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

        // Update ACC status
        $acc->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'responded_at' => Carbon::now(),
        ]);

        // Update StatusUndangan konfirmasi
        StatusUndangan::where('id_undangan', $acc->id_undangan)
            ->where('id_dosen', $acc->id_dosen)
            ->update([
                'status_konfirmasi' => 'Tidak Hadir',
                'alasan_penolakan' => $request->alasan_penolakan,
                'confirmed_at' => Carbon::now(),
            ]);

        // Cek apakah masih mungkin terpenuhi
        $undangan = $acc->undangan;
        $check = WhatsappService::checkMinimumRequirements($undangan->id);

        if ($check['tidak_mungkin']) {
            // Tidak mungkin terpenuhi lagi, gagalkan ujian
            $undangan->update(['status_ujian' => 'gagal_menjadwalkan_ujian']);
        }

        // Log penolakan
        $waService = new WhatsappService();
        $waService->sendAccRejectedNotification($acc);

        $roleLabel = WhatsappService::getRoleLabel($acc->role);

        return redirect()->route('acc.kesiapan.form', ['token' => $token])
            ->with('success', "ACC sebagai {$roleLabel} telah ditolak. Admin akan menindaklanjuti.");
    }
}