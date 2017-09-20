<?php

namespace HLW\Http\Controllers;

use HLW\Matchweek;
use HLW\Season;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
