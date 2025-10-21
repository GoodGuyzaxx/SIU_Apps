<?php

use App\Http\Controllers\UndanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/user');
});

Route::get('/admin/undangan/pdf/{id}',[\App\Http\Controllers\UndanganController::class, 'getPDF'] )->name('undangan.pdf');

Route::get('/admin/sk/pdf/{id}', [UndanganController::class, 'getSkPDF'] )->name('skPDF');

Route::get('/admin/berita-acara/pdf/{id}/{jenis}/{waktu}', [UndanganController::class, 'getBeritaAcaraPdf'] )->name('beritaPDF');
