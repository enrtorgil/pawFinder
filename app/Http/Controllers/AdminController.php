<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use App\Models\Report;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::simplePaginate(10);
        return view('admin.users', compact('users'));
    }

    public function publications()
    {
        $publications = Publication::simplePaginate(10);
        return view('admin.publications', compact('publications'));
    }

    public function reports()
    {
        $reports = Report::with(['user', 'publication'])->simplePaginate(10);
        return view('admin.reports', compact('reports'));
    }
}
