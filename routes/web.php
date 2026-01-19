<?php

use App\Http\Controllers\UndanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/user');
});

Route::get('/dokumen/undangan/pdf/{id}',[\App\Http\Controllers\UndanganController::class, 'getPDF'] )->name('undangan.pdf');
Route::get('/dokumen/undangan/pdf/ttd/{id}',[\App\Http\Controllers\UndanganController::class, 'getTtdPDF'] )->name('undangan.ttd.pdf');

Route::get('info', \App\Livewire\PapanInfo::class)->name('info');

Route::get('/dokumen/sk/pdf/{id}', [UndanganController::class, 'getSkPDF'] )->name('skPDF');

Route::get('/dokumen/sk/pdf/ttd/{id}', [UndanganController::class, 'getTtdSkPDF'] )->name('skttdPDF');

Route::get('/admin/berita-acara/pdf/{id}/{jenis}', [UndanganController::class, 'getBeritaAcaraPdf'] )->name('beritaPDF');

Route::get('mobile/info', \App\Livewire\PapanInfoMobileSetting::class)->name('info.mobile');
