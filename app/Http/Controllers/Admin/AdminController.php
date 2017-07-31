<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        // TODO: Rollenbasiertes Dashboard?

        $competitions = Competition::with('divisions', 'divisions.seasons', 'divisions.seasons.matchweeks')->get();

        return view('admin.index', compact('competitions'));
    }
}
