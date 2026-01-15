<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Judul;
use App\Models\SuratKeputusan;
use App\Models\Undangan;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use function Spatie\LaravelPdf\Support\pdf as pdf;

class UndanganController extends Controller
{

    public function getPDF($id) {
        $data = Undangan::find($id);
        return pdf()
            ->view('pdf.undangan.undangan_pdf', compact('data'))
            ->format(Format::A4)
            ->name($data->perihal.' '.$data->judul->mahasiswa->nama.' '.$data->judul->mahasiswa->npm.'.pdf');
    }

    public function getTtdPDF($id) {
        $data = Undangan::find($id);
        return pdf()
            ->view('pdf.undangan.undangan_ttd_pdf', compact('data'))
            ->format(Format::A4)
            ->name($data->perihal.' '.$data->judul->mahasiswa->nama.' '.$data->judul->mahasiswa->npm.'.pdf');
    }


    public function getSkPDF($id){
        $data = SuratKeputusan::findOrFail($id);
        return pdf()
            ->view('pdf.sk.sk_pdf',compact('data'))
            ->format(Format::Legal)
            ->name('Surat Keputusan Mahasiswa '.$data->judul->mahasiswa->nama.' '.$data->judul->mahasiswa->npm.'.pdf');
    }

    public function getTtdSkPDF($id){
        $data = SuratKeputusan::findOrFail($id);
        return pdf()
            ->view('pdf.sk.sk_ttd_pdf',compact('data'))
            ->format(Format::Legal)
            ->name('Surat Keputusan Mahasiswa '.$data->judul->mahasiswa->nama.' '.$data->judul->mahasiswa->npm.'.pdf');;
    }

    public function getBeritaAcaraPdf($id,$jenis,$waktu){
        $data = Judul::find($id);
        $dosenList = array($data->pembimbing_satu,$data->pembimbing_dua,$data->penguji_satu,$data->penguji_dua);
        $inisialDosen = Dosen::whereIn('nama',$dosenList)->get();
        if ($jenis != 'proposal') {
            $pdf = DomPdf::loadView('pdf.hasil.berita_acara_hasil_pdf', compact('data','waktu','inisialDosen'));
            return $pdf->stream();
        }
        $pdf = DomPdf::loadView('pdf.proposal.berita_acara_proposal_pdf', compact('data','waktu','inisialDosen'));
        return $pdf->stream();


    }

}
