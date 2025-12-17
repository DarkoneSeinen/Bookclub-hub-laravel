<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of clubs.
     */
    public function index()
    {
        return view('clubs.index');
    }

    /**
     * Show the form for creating a new club.
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Display the specified club.
     */
    public function show(Club $club)
    {
        return view('clubs.show', compact('club'));
    }
}
