<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeputusan extends Model
{
    //
    protected $table = 'surat_keputusan';

    protected $fillable = [
        'id_judul',
        'menimbang',
        'mengingat',
        'memperhatikan',
        'nomor_sk_penguji',
        'nomor_sk_pembimbing',
        'signed'
    ];

    protected $attributes = [
        'menimbang' => '<ol start="1"><li><p>Bahwa untuk memperlancar proses penyusunan skripsi  mahasiswa perlu adanya bimbingan dan pengarahan dari dosen penguji.</p></li><li><p>Bahwa sehubungan dengan butir (1) tersebut diatas, maka perlu ditetapkan Surat Keputusan Dekan Fakutas Hukum Universitas Doktor Husni Ingratubun (UNINGRAT) Papua.</p></li></ol>',
        'mengingat' => '<ol start="1"><li><p>Undang-Undang RI Nomor 20 Tahun 2003 Tentang Sistem   Pendidikan Nasional.</p></li><li><p>Undang-Undang RI Nomor 14 Tahun 2005 Tentang Guru dan Dosen.</p></li><li><p style="text-align: justify;">Undang-Undang RI Nomor 12 Tahun 2012 Tentang Pendidikan Tinggi.</p></li><li><p style="text-align: justify;">Peraturan Pemerintah RI Nomor 4 Tahun 2014 Tentang Pengelolaan dan Penyelenggaraan Pendidikan.</p></li><li><p style="text-align: justify;">Akreditasi Program Studi S.1 (B) oleh BAN-PT Nomor : 13821/SK/BAN-PT/Ak-PPJ/S/I/2022 tanggal 12 Januari 2022.</p></li></ol>',
        'memperhatikan' => 'Hasil Rapat Ketua Program Studi Ilmu Hukum Bersama Dosen Pada Tanggal Hari Bulan Tahun.'

    ];


    public function judul(): BelongsTo {
        return $this->belongsTo(Judul::class, 'id_judul');
    }
}
