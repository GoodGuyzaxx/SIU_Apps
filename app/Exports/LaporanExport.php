<?php

namespace App\Exports;

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

    public function __construct(Collection $data, ?string $tahunAkademikLabel = null)
    {
        $this->data                = $data;
        $this->tahunAkademikLabel  = $tahunAkademikLabel;
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

        // Lebar kolom (A–S = 19 kolom)
        $sheet->getColumnDimension('A')->setWidth(10);   // No
        $sheet->getColumnDimension('B')->setWidth(15);  // NPM
        $sheet->getColumnDimension('C')->setWidth(28);  // Nama
        $sheet->getColumnDimension('D')->setWidth(20);  // Kelas
        $sheet->getColumnDimension('E')->setWidth(40);  // Pembimbing 1
        $sheet->getColumnDimension('F')->setWidth(40);  // Pembimbing 2
        $sheet->getColumnDimension('G')->setWidth(40);  // Penguji 1
        $sheet->getColumnDimension('H')->setWidth(40);  // Penguji 2
        $sheet->getColumnDimension('I')->setWidth(70);  // Judul
        $sheet->getColumnDimension('J')->setWidth(30);  // Konsentrasi
        $sheet->getColumnDimension('K')->setWidth(20);  // Nomor SK Pembimbing
        $sheet->getColumnDimension('L')->setWidth(20);  // Tanggal SK Pembimbing
        $sheet->getColumnDimension('M')->setWidth(20);  // Nomor SK Penguji
        $sheet->getColumnDimension('N')->setWidth(20);  // Tanggal SK Penguji
        $sheet->getColumnDimension('O')->setWidth(20);  // Nilai Proposal
        $sheet->getColumnDimension('P')->setWidth(20);  // Tanggal Ujian Proposal
        $sheet->getColumnDimension('Q')->setWidth(20);  // Nilai Hasil
        $sheet->getColumnDimension('R')->setWidth(20);  // Tanggal Ujian Hasil
        $sheet->getColumnDimension('S')->setWidth(14);  // Status

        $totalCols = 'S'; // kolom terakhir yang dipakai

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

        // Program Studi
        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'PROGRAM STUDI ILMU HUKUM');
        $sheet->getRowDimension($row)->setRowHeight(16);
        $this->styleCenter($sheet, "A{$row}", bold: false, size: 11);
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

        // Tampilkan filter tahun akademik jika ada
        $label = $this->tahunAkademikLabel ?? 'Semua Tahun Akademik';
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
            'D' => 'Kelas',
            'E' => 'Pembimbing 1',
            'F' => 'Pembimbing 2',
            'G' => 'Penguji 1',
            'H' => 'Penguji 2',
            'I' => 'Judul',
            'J' => 'Konsentrasi',
            'K' => 'No. SK Pembimbing',
            'L' => 'Tanggal SK Pembimbing',
            'M' => 'No. SK Penguji',
            'N' => 'Tanggal SK Penguji',
            'O' => 'Nilai Proposal',
            'P' => 'Tanggal Ujian Proposal',
            'Q' => 'Nilai Hasil',
            'R' => 'Tanggal Ujian Hasil',
            'S' => 'Status',
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue("{$col}{$row}", str_replace('\n', "\n", $label));
        }

        $sheet->getStyle("A{$row}:S{$row}")->applyFromArray([
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

            // ── Ambil data relasi (sama persis dengan formatStateUsing di LaporansTable) ──

            $npm  = $judul->mahasiswa->npm  ?? '-';
            $nama = $judul->mahasiswa->nama ?? '-';
            $kelas = $judul->mahasiswa->kelas ?? '-';
            $pembimbingSatu = $judul->pembimbingSatu->nama ?? '-';
            $pembimbingDua = $judul->pembimbingDua->nama ?? '-';
            $pengujiSatu = $judul->pengujiSatu->nama ?? '-';
            $pengujiDua = $judul->pengujiDua->nama ?? '-';

            $judulSkripsi = $judul->judul ?? '-';
            $konsentrasi = $judul->minat ?? '-';
            // Field 'dibuat' tidak ada di model SuratKeputusan — pakai created_at sebagai fallback
            $skCreatedAt            = $judul->suratKeputusan?->created_at;
            $tanggalTerbitSk        = $skCreatedAt
                ? Carbon::parse($skCreatedAt)->translatedFormat('d F Y')
                : '-';
            $tanggalTerbitSkPenguji = $tanggalTerbitSk; // sama sumber, bisa diubah jika nanti ada field terpisah
            $noSKPembimbing         = $judul->suratKeputusan?->nomor_sk_pembimbing ?? '-';
            $noSKPenguji            = $judul->suratKeputusan?->nomor_sk_penguji    ?? '-';


            $tahunAkademik = $judul->tahunAkademik
                ? '[' . $judul->tahunAkademik->takad . '-' . $judul->tahunAkademik->priode . ']-' . $judul->tahunAkademik->status
                : '-';

            // nilai_porposal (typo di DB sesuai model) / nilai_hasil
            $nilaiProposal = $judul->nilai->nilai_proposal ?? 'Belum ada';
            $tanggalUjianProposal = $judul->nilai->tanggal_ujian_proposal ?? 'Belum ada';
            $nilaiHasil = $judul->nilai->nilai_hasil ?? 'Belum ada';
            $tanggalUjianHasil = $judul->nilai->tanggal_ujian_hasil ?? 'Belum ada';


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
                'D' => $kelas,
                'E' => $pembimbingSatu,
                'F' => $pembimbingDua,
                'G' => $pengujiSatu,
                'H' => $pengujiDua,
                'I' => $judulSkripsi,
                'J' => $konsentrasi,
                'K' => $noSKPembimbing,
                'L' => $tanggalTerbitSk,
                'M' => $noSKPenguji,
                'N' => $tanggalTerbitSkPenguji,
                'O' => $nilaiProposal,
                'P' => $tanggalUjianProposal,
                'Q' => $nilaiHasil,
                'R' => $tanggalUjianHasil,
                'S' => $status,


            ];

            foreach ($rowData as $col => $value) {
                $sheet->setCellValue("{$col}{$row}", $value);
            }

            // ── Style baris ──
            $sheet->getStyle("A{$row}:S{$row}")->applyFromArray([
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
            foreach (['A', 'B', 'C', 'D'] as $col) {
                $sheet->getStyle("{$col}{$row}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Warna teks status (sesuai badge Filament)
            $sheet->getStyle("S{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => $statusColor]],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(20);

            $counter++;
            $row++;
        }

        // Baris total / summary (sesuai summarize Count di LaporansTable)
        $sheet->mergeCells("A{$row}:R{$row}");
        $sheet->setCellValue("A{$row}", 'Total');
        $sheet->setCellValue("S{$row}", $this->data->count());
        $sheet->getStyle("A{$row}:S{$row}")->applyFromArray([
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
        $row += 2;

        // Tanda tangan di kanan (kolom F–H)
        $ttdRange = "Q{$row}:{$lastCol}{$row}";
        $sheet->mergeCells($ttdRange);
        $sheet->setCellValue("F{$row}", 'Mengetahui,');
        $this->styleCenter($sheet, "F{$row}");
        $row++;

        $sheet->mergeCells("Q{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("Q{$row}", 'Dekan Fakultas Hukum');
        $this->styleCenter($sheet, "Q{$row}");
        $row++;

        for ($i = 0; $i < 4; $i++) {
            $sheet->getRowDimension($row)->setRowHeight(15);
            $row++;
        }

        $sheet->mergeCells("Q{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("Q{$row}", 'Dr. Nama Dekan, S.H., M.H.');
        $sheet->getStyle("F{$row}")->applyFromArray([
            'font'      => ['bold' => true, 'underline' => true, 'size' => 10, 'name' => 'Arial'],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $row++;

        $sheet->mergeCells("Q{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("Q{$row}", 'NIDN. 0000000000');
        $this->styleCenter($sheet, "Q{$row}");
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
