<?php

use App\Http\Controllers\UndanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/user/login');
});

Route::get('/dokumen/undangan/pdf/{id}', [\App\Http\Controllers\UndanganController::class , 'getPDF'])->name('undangan.pdf');
Route::get('/dokumen/undangan/pdf/ttd/{id}', [\App\Http\Controllers\UndanganController::class , 'getTtdPDF'])->name('undangan.ttd.pdf');

Route::get('info', \App\Livewire\PapanInfo::class)->name('info');
Route::get('berita', \App\Livewire\PapanBerita::class)->name('berita');

Route::get('/dokumen/sk/pdf/{id}', [UndanganController::class , 'getSkPDF'])->name('skPDF');

Route::get('/dokumen/sk/pdf/ttd/{id}', [UndanganController::class , 'getTtdSkPDF'])->name('skttdPDF');

Route::get('/admin/berita-acara/pdf/{id}/{jenis}', [UndanganController::class , 'getBeritaAcaraPdf'])->name('beritaPDF');

Route::get('mobile/info', \App\Livewire\PapanInfoMobileSetting::class)->name('info.mobile');

// ACC Kesiapan Ujian Routes (public, accessible via token)
Route::get('/acc-kesiapan/{token}', [\App\Http\Controllers\AccKesiapanController::class , 'show'])->name('acc.kesiapan.form');
Route::post('/acc-kesiapan/{token}/setujui', [\App\Http\Controllers\AccKesiapanController::class , 'setujui'])->name('acc.kesiapan.setujui');
Route::post('/acc-kesiapan/{token}/tolak', [\App\Http\Controllers\AccKesiapanController::class , 'tolak'])->name('acc.kesiapan.tolak');
