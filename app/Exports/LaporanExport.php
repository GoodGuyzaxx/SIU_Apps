<?php

namespace App\Exports;

use App\Models\ConfigDokumen;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanExport
{
    protected Collection $data;

    // Info filter yang aktif (opsional, untuk ditampilkan di info cetak)
    protected ?string $tahunAkademikLabel;
    protected ?string $prodiLabel;

    public function __construct(Collection $data, ?string $tahunAkademikLabel = null, ?string $prodiLabel = null)
    {
        $this->data                = $data;
        $this->tahunAkademikLabel  = $tahunAkademikLabel;
        $this->prodiLabel          = $prodiLabel;
    }

    // ──────────────────────────────────────────────────────────
    // Entry point: kembalikan response download
    // ──────────────────────────────────────────────────────────

    public function download(string $filename = 'laporan-skripsi.xlsx'): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $spreadsheet = $this->build();

        $tmp    = tempnam(sys_get_temp_dir(), 'laporan_');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tmp);

        return response()->download($tmp, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    // ──────────────────────────────────────────────────────────
    // Build spreadsheet
    // ──────────────────────────────────────────────────────────

    protected function build(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Skripsi');

        // Lebar kolom (A–U = 21 kolom)
        $sheet->getColumnDimension('A')->setWidth(6);    // No
        $sheet->getColumnDimension('B')->setWidth(15);   // NPM
        $sheet->getColumnDimension('C')->setWidth(28);   // Nama
        $sheet->getColumnDimension('D')->setWidth(28);   // Program Studi
        $sheet->getColumnDimension('E')->setWidth(20);   // Tahun Akademik
        $sheet->getColumnDimension('F')->setWidth(15);   // Kelas
        $sheet->getColumnDimension('G')->setWidth(35);   // Pembimbing 1
        $sheet->getColumnDimension('H')->setWidth(35);   // Pembimbing 2
        $sheet->getColumnDimension('I')->setWidth(35);   // Penguji 1
        $sheet->getColumnDimension('J')->setWidth(35);   // Penguji 2
        $sheet->getColumnDimension('K')->setWidth(60);   // Judul
        $sheet->getColumnDimension('L')->setWidth(25);   // Konsentrasi
        $sheet->getColumnDimension('M')->setWidth(22);   // Nomor SK Pembimbing
        $sheet->getColumnDimension('N')->setWidth(22);   // Tanggal SK Pembimbing
        $sheet->getColumnDimension('O')->setWidth(22);   // Nomor SK Penguji
        $sheet->getColumnDimension('P')->setWidth(22);   // Tanggal SK Penguji
        $sheet->getColumnDimension('Q')->setWidth(16);   // Nilai Proposal (Huruf)
        $sheet->getColumnDimension('R')->setWidth(16);   // Nilai Proposal (Angka)
        $sheet->getColumnDimension('S')->setWidth(22);   // Tanggal Ujian Proposal
        $sheet->getColumnDimension('T')->setWidth(16);   // Nilai Hasil (Huruf)
        $sheet->getColumnDimension('U')->setWidth(16);   // Nilai Hasil (Angka)
        $sheet->getColumnDimension('V')->setWidth(22);   // Tanggal Ujian Hasil
        $sheet->getColumnDimension('W')->setWidth(14);   // Status

        $totalCols = 'W'; // kolom terakhir yang dipakai

        $row = 1;
        $row = $this->buildKopSurat($sheet, $row, $totalCols);
        $row = $this->buildJudul($sheet, $row, $totalCols);
        $row = $this->buildInfoCetak($sheet, $row);
        $row = $this->buildTableHeader($sheet, $row);
        $row = $this->buildTableData($sheet, $row);
        $this->buildFooter($sheet, $row, $totalCols);

        return $spreadsheet;
    }

    // ──────────────────────────────────────────────────────────
    // 1. Kop Surat
    // ──────────────────────────────────────────────────────────

    protected function buildKopSurat($sheet, int $row, string $lastCol): int
    {
        // Ruang logo (tinggi 55 pt – sisipkan logo manual via Insert > Image)
        $sheet->getRowDimension($row)->setRowHeight(55);
        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $row++;

        // Nama yayasan / kementerian (opsional)
        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'UNIVERSITAS DOKTOR HUSNI INGRATUBUN (UNINGRAT) PAPUA');
        $sheet->getRowDimension($row)->setRowHeight(18);
        $this->styleCenter($sheet, "A{$row}", bold: true, size: 13);
        $row++;

        // Nama Fakultas
        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'FAKULTAS HUKUM');
        $sheet->getRowDimension($row)->setRowHeight(20);
        $this->styleCenter($sheet, "A{$row}", bold: true, size: 15);
        $row++;

        // Alamat
        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'Jl. Raya Abepura Kotaraja (Depan Perpustakaan Daerah),Kec. Abepura, Kota Jayapura, Papua – Indonesia 99351. |  Telp. (0916) 123456  |  Email: info@uningrat.ac.id');
        $sheet->getRowDimension($row)->setRowHeight(14);
        $this->styleCenter($sheet, "A{$row}", bold: false, size: 10);
        $row++;

        // Garis tebal biru
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THICK, 'color' => ['rgb' => '1F3864']]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(4);
        $row++;

        // Garis tipis biru
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '1F3864']]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(3);
        $row++;

        return $row;
    }

    // ──────────────────────────────────────────────────────────
    // 2. Judul Laporan
    // ──────────────────────────────────────────────────────────

    protected function buildJudul($sheet, int $row, string $lastCol): int
    {
        $sheet->getRowDimension($row)->setRowHeight(8);
        $row++;

        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'LAPORAN DATA SKRIPSI MAHASISWA');
        $sheet->getRowDimension($row)->setRowHeight(20);
        $this->styleCenter($sheet, "A{$row}", bold: true, size: 13, underline: true);
        $row++;

        // Tampilkan filter tahun akademik dan prodi jika ada
        $taLabel    = $this->tahunAkademikLabel ?? 'Semua Tahun Akademik';
        $prodiText  = $this->prodiLabel ? ' | Program Studi: ' . $this->prodiLabel : '';
        $label      = $taLabel . $prodiText;
        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", $label);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $this->styleCenter($sheet, "A{$row}", bold: false, size: 11);
        $row++;

        $sheet->getRowDimension($row)->setRowHeight(6);
        $row++;

        return $row;
    }

    // ──────────────────────────────────────────────────────────
    // 3. Info Cetak
    // ──────────────────────────────────────────────────────────

    protected function buildInfoCetak($sheet, int $row): int
    {
        $infoStyle = ['font' => ['size' => 10, 'name' => 'Arial']];

        $sheet->setCellValue("A{$row}", 'Tanggal Cetak');
        $sheet->setCellValue("B{$row}", ': ' . now()->translatedFormat('d F Y'));
        $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($infoStyle);
        $row++;

        // Hitung per status
        $rekap = $this->data->groupBy('status')->map->count();

        $sheet->setCellValue("A{$row}", 'Total Data');
        $sheet->setCellValue("B{$row}", ': ' . $this->data->count() . ' mahasiswa');
        $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($infoStyle);
        $row++;

        $sheet->setCellValue("A{$row}", 'Rekap Status');
        $sheet->setCellValue("B{$row}", sprintf(
            ': Pengajuan: %d  |  Proposal: %d  |  Hasil: %d',
            $rekap->get('pengajuan', 0),
            $rekap->get('proposal', 0),
            $rekap->get('hasil', 0),
        ));
        $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($infoStyle);
        $row++;

        $sheet->getRowDimension($row)->setRowHeight(6);
        $row++;

        return $row;
    }

    // ──────────────────────────────────────────────────────────
    // 4. Header Tabel  — persis kolom di LaporansTable
    // ──────────────────────────────────────────────────────────

    protected function buildTableHeader($sheet, int $row): int
    {
        $headers = [
            'A' => 'No',
            'B' => 'NPM',
            'C' => 'Nama',
            'D' => 'Program Studi',
            'E' => 'Tahun Akademik',
            'F' => 'Kelas',
            'G' => 'Pembimbing 1',
            'H' => 'Pembimbing 2',
            'I' => 'Penguji 1',
            'J' => 'Penguji 2',
            'K' => 'Judul',
            'L' => 'Konsentrasi',
            'M' => 'No. SK Pembimbing',
            'N' => 'Tanggal SK Pembimbing',
            'O' => 'No. SK Penguji',
            'P' => 'Tanggal SK Penguji',
            'Q' => 'Nilai Proposal',
            'R' => 'Nilai Proposal (Angka)',
            'S' => 'Tanggal Ujian Proposal',
            'T' => 'Nilai Hasil',
            'U' => 'Nilai Hasil (Angka)',
            'V' => 'Tanggal Ujian Hasil',
            'W' => 'Status',
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue("{$col}{$row}", str_replace('\n', "\n", $label));
        }

        $sheet->getStyle("A{$row}:W{$row}")->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 10,
                'name'  => 'Arial',
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F3864'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']],
            ],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(30);

        return $row + 1;
    }

    // ──────────────────────────────────────────────────────────
    // 5. Data Tabel
    // ──────────────────────────────────────────────────────────

    protected function buildTableData($sheet, int $row): int
    {
        $counter = 1;

        foreach ($this->data as $judul) {
            $isEven  = ($counter % 2 === 0);
            $bgColor = $isEven ? 'DCE6F1' : 'FFFFFF';

            // ── Ambil data relasi ──

            $npm           = $judul->mahasiswa->npm   ?? '-';
            $nama          = $judul->mahasiswa->nama  ?? '-';
            $programStudi  = $judul->mahasiswa->prodi->nama_prodi ?? ($judul->mahasiswa->program_studi ?? '-');
            $kelas         = $judul->mahasiswa->kelas ?? '-';

            $tahunAkademik = $judul->tahunAkademik
                ? '[' . $judul->tahunAkademik->takad . '-' . $judul->tahunAkademik->priode . ']-' . $judul->tahunAkademik->status
                : '-';

            $pembimbingSatu = $judul->pembimbingSatu->nama ?? '-';
            $pembimbingDua  = $judul->pembimbingDua->nama  ?? '-';
            $pengujiSatu    = $judul->pengujiSatu->nama    ?? '-';
            $pengujiDua     = $judul->pengujiDua->nama     ?? '-';

            $judulSkripsi = $judul->judul ?? '-';
            $konsentrasi  = $judul->minat ?? '-';

            // SK
            $skCreatedAt            = $judul->suratKeputusan?->created_at;
            $tanggalTerbitSk        = $skCreatedAt
                ? Carbon::parse($skCreatedAt)->translatedFormat('d F Y')
                : '-';
            $tanggalTerbitSkPenguji = $tanggalTerbitSk;
            $noSKPembimbing         = $judul->suratKeputusan?->nomor_sk_pembimbing ?? '-';
            $noSKPenguji            = $judul->suratKeputusan?->nomor_sk_penguji    ?? '-';

            // Semua field Nilai
            $nilaiProposalHuruf    = $judul->nilai?->nilai_proposal        ?? '-';
            $nilaiProposalAngka    = $judul->nilai?->nilai_proposal_angka  ?? '-';
            $tanggalUjianProposal  = $judul->nilai?->tanggal_ujian_proposal
                ? Carbon::parse($judul->nilai->tanggal_ujian_proposal)->translatedFormat('d F Y')
                : '-';
            $nilaiHasilHuruf       = $judul->nilai?->nilai_hasil           ?? '-';
            $nilaiHasilAngka       = $judul->nilai?->nilai_hasil_angka     ?? '-';
            $tanggalUjianHasil     = $judul->nilai?->tanggal_ujian_hasil
                ? Carbon::parse($judul->nilai->tanggal_ujian_hasil)->translatedFormat('d F Y')
                : '-';

            $status = match ($judul->status) {
                'hasil'     => 'Hasil',
                'proposal'  => 'Proposal',
                'pengajuan' => 'Pengajuan',
                default     => ucfirst($judul->status ?? '-'),
            };

            // ── Warna badge status ──
            $statusColor = match ($judul->status) {
                'hasil'     => '00B050', // hijau
                'proposal'  => 'FFC000', // kuning
                'pengajuan' => 'FF0000', // merah
                default     => '808080',
            };

            // ── Isi sel ──
            $rowData = [
                'A' => $counter,
                'B' => $npm,
                'C' => $nama,
                'D' => $programStudi,
                'E' => $tahunAkademik,
                'F' => $kelas,
                'G' => $pembimbingSatu,
                'H' => $pembimbingDua,
                'I' => $pengujiSatu,
                'J' => $pengujiDua,
                'K' => $judulSkripsi,
                'L' => $konsentrasi,
                'M' => $noSKPembimbing,
                'N' => $tanggalTerbitSk,
                'O' => $noSKPenguji,
                'P' => $tanggalTerbitSkPenguji,
                'Q' => $nilaiProposalHuruf,
                'R' => $nilaiProposalAngka,
                'S' => $tanggalUjianProposal,
                'T' => $nilaiHasilHuruf,
                'U' => $nilaiHasilAngka,
                'V' => $tanggalUjianHasil,
                'W' => $status,
            ];

            foreach ($rowData as $col => $value) {
                $sheet->setCellValue("{$col}{$row}", $value);
            }

            // ── Style baris ──
            $sheet->getStyle("A{$row}:W{$row}")->applyFromArray([
                'font' => ['size' => 10, 'name' => 'Arial'],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['rgb' => 'B8CCE4'],
                    ],
                ],
            ]);

            // Kolom tengah
            foreach (['A', 'B', 'F'] as $col) {
                $sheet->getStyle("{$col}{$row}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
            // Kolom nilai & angka tengah
            foreach (['Q', 'R', 'T', 'U'] as $col) {
                $sheet->getStyle("{$col}{$row}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Warna teks status (sesuai badge Filament)
            $sheet->getStyle("W{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => $statusColor]],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(22);

            $counter++;
            $row++;
        }

        // Baris total / summary
        $sheet->mergeCells("A{$row}:V{$row}");
        $sheet->setCellValue("A{$row}", 'Total');
        $sheet->setCellValue("W{$row}", $this->data->count());
        $sheet->getStyle("A{$row}:W{$row}")->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F3864'],
            ],
            'font'      => ['bold' => true, 'size' => 10, 'name' => 'Arial', 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(18);

        return $row + 1;
    }

    // ──────────────────────────────────────────────────────────
    // 6. Footer tanda tangan
    // ──────────────────────────────────────────────────────────

    protected function buildFooter($sheet, int $row, string $lastCol): void
    {
        $dekan =ConfigDokumen::where('jabatan', 'dekan')->first();
        $row += 2;

        $ttdStyle = [
            'font'      => ['size' => 10, 'name' => 'Arial'],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];


        // ── Blok Kanan: Tanda Tangan Dekan (kolom R–W) ──
        $sheet->mergeCells("R{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("R{$row}", 'Mengetahui,');
        $sheet->getStyle("R{$row}")->applyFromArray($ttdStyle);
        $row++;

        $sheet->mergeCells("R{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("R{$row}", 'Dekan Fakultas Hukum,');
        $sheet->getStyle("R{$row}")->applyFromArray($ttdStyle);
        $row++;

        // Ruang tanda tangan (4 baris kosong)
        for ($i = 0; $i < 4; $i++) {
            $sheet->getRowDimension($row)->setRowHeight(15);
            $row++;
        }


        // Nama Dekan (kanan)
        $sheet->mergeCells("R{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("R{$row}", $dekan->nama ?? '-');
        $sheet->getStyle("R{$row}")->applyFromArray([
            'font'      => ['bold' => true, 'underline' => true, 'size' => 10, 'name' => 'Arial'],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $row++;

        // NIDN Dekan (kanan)
        $sheet->mergeCells("R{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("R{$row}", 'NRP.'.$dekan->nrp ?? '-');
        $sheet->getStyle("R{$row}")->applyFromArray($ttdStyle);
    }

    // ──────────────────────────────────────────────────────────
    // Helper: style teks tengah
    // ──────────────────────────────────────────────────────────

    protected function styleCenter($sheet, string $cell, bool $bold = false, int $size = 10, bool $underline = false): void
    {
        $sheet->getStyle($cell)->applyFromArray([
            'font'      => [
                'bold'      => $bold,
                'size'      => $size,
                'name'      => 'Arial',
                'underline' => $underline,
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
    }
}
