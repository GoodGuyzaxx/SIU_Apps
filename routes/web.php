<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin/undangan/pdf/{id}',[\App\Http\Controllers\UndanganController::class, 'getPDF'] )->name('undangan.pdf');
