<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Report;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function destroy($publication_id, $user_id, $created_at)
    {
        $created_at = Carbon::parse($created_at);

        Report::where('publication_id', $publication_id)
            ->where('user_id', $user_id)
            ->where('created_at', $created_at)
            ->delete();

        return redirect()->route('admin.reports')->with('success', 'Reporte eliminado correctamente.');
    }
}
