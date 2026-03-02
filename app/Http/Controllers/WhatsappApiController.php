<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappApiController extends Controller
{
    //
    public function sendMessage(){

        $request = Http::withBasicAuth(config('gowaapi.user'),config('gowaapi.pass'))
            ->withHeaders([
                'Accept' => 'application/json',
                'X-Device-Id' => config('gowaapi.device'),
            ])
            ->post(config('gowaapi.url'),[
                'phone' => '6282266699447@s.whatsapp.net',
                'link' => 'https://docs.docker.com/engine/install/ubuntu/',
                'caption' => 'Undangan Ujian {Proposal/Skripsi}\n\nYth. Bapak/Ibu {Nama},\nMohon kesediaan hadir sebagai {Penguji/Pembimbing} pada ujian:\n\nMahasiswa : {Nama Mahasiswa}\nTanggal : {Tanggal} | {Jam}\n\nKonfirmasi kehadiran melalui link dibawah\n\nTerima kasih.\nSistem Akademik Uningrat Papua'
            ]);

        $request->successful();
    }
}
