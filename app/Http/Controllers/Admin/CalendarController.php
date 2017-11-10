<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Fixture;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;

class CalendarController extends Controller
{
    //
    public function index()
    {
        $fixtures = Fixture::whereNotNull('datetime')->get();

        return view('admin.calendar', compact('fixtures'));
    }
}
