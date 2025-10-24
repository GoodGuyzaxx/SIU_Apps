<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Judul;
use App\Models\SuratKeputusan;
use App\Models\Undangan;
use Barryvdh\DomPDF\Facade\Pdf;

class UndanganController extends Controller
{

    public function getPDF($id) {
        $data = Undangan::find($id);
        $pdf = PDF::loadView('pdf.undangan.undangan_pdf', compact('data'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream();
    }

    public function getTtdPDF($id) {
        $data = Undangan::find($id);
        $pdf = PDF::loadView('pdf.undangan.undangan_ttd_pdf', compact('data'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream();
    }


    public function getSkPDF($id){
        $data = SuratKeputusan::find($id);
        $pdf = PDF::loadView('pdf.sk.sk_pdf', compact('data'));
        return $pdf->stream();
    }

    public function getTtdSkPDF($id){
        $data = SuratKeputusan::find($id);
        $pdf = PDF::loadView('pdf.sk.sk_ttd_pdf', compact('data'));
        return $pdf->stream();
    }

    public function getBeritaAcaraPdf($id,$jenis,$waktu){
        $data = Judul::find($id);
        $dosenList = array($data->pembimbing_satu,$data->pembimbing_dua,$data->penguji_satu,$data->penguji_dua);
        $inisialDosen = Dosen::whereIn('nama',$dosenList)->get();
        if ($jenis != 'proposal') {
            $pdf = PDF::loadView('pdf.hasil.berita_acara_hasil_pdf', compact('data','waktu','inisialDosen'));
            return $pdf->stream();
        }
        $pdf = PDF::loadView('pdf.proposal.berita_acara_proposal_pdf', compact('data','waktu','inisialDosen'));
        return $pdf->stream();


    }

}
