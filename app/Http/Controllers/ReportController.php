<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\User;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $users = User::with(['reports.publication'])->get();
        $reports = collect();

        foreach ($users as $user) {
            foreach ($user->reports as $report) {
                $report->user = $user;
                $reports->push($report);
            }
        }

        return view('admin.reports', compact('reports'));
    }

    /**
     * @param ReportRequest $request
     * @param Publication $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function report(ReportRequest $request, Publication $publication)
    {
        /** @var User $user */
        $user = Auth::user();

        if (method_exists($user, 'reports')) {
            $user->reports()->attach($publication->id, [
                'reason' => $request->input('reason'),
                'additional_info' => $request->input('additional_info'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return back()->with('success', 'Reporte enviado al administrador.');
        }
        return back()->with('error', 'No se pudo enviar el reporte.');
    }

    public function destroy($publication_id, $user_id, $created_at)
    {
        $created_at = Carbon::parse($created_at);

        $user = User::findOrFail($user_id);
        $user->reports()->wherePivot('publication_id', $publication_id)
            ->wherePivot('created_at', $created_at)
            ->detach($publication_id);

        return redirect()->route('admin.reports')->with('success', 'Reporte eliminado correctamente.');
    }
}
