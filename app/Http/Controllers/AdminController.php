<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $users = User::orderBy($column, $sort)->simplePaginate(9);

        return view('admin.users', compact('users'));
    }

    public function publications(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $publications = Publication::orderBy($column, $sort)->simplePaginate(9);

        return view('admin.publications', compact('publications'));
    }

    public function reports(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $reportsQuery = User::join('reports', 'users.id', '=', 'reports.user_id')
            ->join('publications', 'publications.id', '=', 'reports.publication_id')
            ->select('reports.*', 'users.username', 'publications.name as publication_name');

        if ($column === 'reason') {
            $reportsQuery->orderByRaw("
                FIELD(reports.reason, 'Contenido inapropiado', 'Información incorrecta', 'Spam', 'Otra razón') $sort
            ");
        } else {
            $reportsQuery->orderBy("reports.$column", $sort);
        }

        $reports = $reportsQuery->simplePaginate(9);

        return view('admin.reports', compact('reports'));
    }
}
