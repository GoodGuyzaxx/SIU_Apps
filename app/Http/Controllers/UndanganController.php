<?php

namespace App\Http\Controllers;

use App\Models\SuratKeputusan;
use App\Models\Undangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UndanganController extends Controller
{

    public function getPDF($id) {
        $data = Undangan::find($id);
        $pdf = PDF::loadView('pdf.undangan_pdf', compact('data'));
        $pdf->setPaper('F4', 'landscape');
        return $pdf->stream();

    }

    public function getSkPDF($id){
        $data = SuratKeputusan::find($id);
        $pdf = PDF::loadView('pdf.sk_pdf', compact('data'));
//        $pdf->setPaper('A4', 'landscape');
//        $pdf->setOption('dpi', 110);                // 96–150 cukup
        $pdf->setOption('defaultFont', 'Times');    // fallback font
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        return $pdf->stream();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
