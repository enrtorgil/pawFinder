<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $users = User::all();
        $publications = Publication::all();
        $reports = Report::all();
        return view('admin.index', compact('users', 'publications', 'reports'));
    }
}
