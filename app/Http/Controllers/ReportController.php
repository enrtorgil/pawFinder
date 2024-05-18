<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
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
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
    public function report(Request $request, Publication $publication)
    {
        // Aquí puedes agregar la lógica para manejar el reporte
        // Por ejemplo, guardar el reporte en la base de datos

        $report = new Report();
        $report->publication_id = $publication->id;
        $report->user_id = Auth::id();
        $report->reason = $request->input('reason');
        $report->save();

        return back()->with('success', 'Reporte enviado al administrador.');
    }
}
