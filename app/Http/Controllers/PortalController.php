<?php

namespace App\Http\Controllers;

use App\Club;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $clubs = Club::orderBy('name')->get();

        return view('index', compact('clubs'));
    }
}
