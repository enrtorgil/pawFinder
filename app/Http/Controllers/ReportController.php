<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Report;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['publication', 'user'])->get();
        return view('admin.reports', compact('reports'));
    }

    public function report(ReportRequest $request, Publication $publication)
    {
        Report::create([
            'publication_id' => $publication->id,
            'user_id' => Auth::id(),
            'reason' => $request->input('reason'),
            'additional_info' => $request->input('additional_info')
        ]);

        return back()->with('success', 'Reporte enviado al administrador.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return back()->with('success', 'Reporte eliminado correctamente.');
    }
}
