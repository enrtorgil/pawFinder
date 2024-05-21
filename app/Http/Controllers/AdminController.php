<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $users = User::orderBy($column, $sort)->simplePaginate(10);

        return view('admin.users', compact('users'));
    }

    public function publications(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        $publications = Publication::orderBy($column, $sort)->simplePaginate(10);

        return view('admin.publications', compact('publications'));
    }

    public function reports(Request $request)
    {
        $sort = $request->query('sort', 'desc');
        $column = $request->query('column', 'created_at');

        if ($column === 'reason') {
            $reports = Report::orderByRaw("
                FIELD(reason, 'Contenido inapropiado', 'Información incorrecta', 'Spam', 'Otra razón') $sort
            ")->with(['user', 'publication'])->simplePaginate(10);
        } else {
            $reports = Report::orderBy($column, $sort)->with(['user', 'publication'])->simplePaginate(10);
        }

        return view('admin.reports', compact('reports'));
    }
}
