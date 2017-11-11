<?php

namespace HLW\Http\Controllers\Admin;

use Carbon\Carbon;
use HLW\Fixture;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
        // TODO: Rollenbasiertes Dashboard?

        // Fixtures in this week
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->endOfWeek();
        $today = Carbon::now();
        $fixtures_this_week = Fixture::whereBetween('datetime', [$monday, $sunday])->notCancelled()->orderBy('datetime')->get();
        $fixtures_this_week->load('matchweek.season');

        // Previous fixtures without result
        $fixtures_without_result = Fixture::where('datetime', '<=', $today)->notPlayedOrRated()->notCancelled()->orderBy('datetime', 'desc')->get();
        $fixtures_without_result->load('matchweek.season');

        return view('admin.index', compact('fixtures_this_week','fixtures_without_result'));
    }
}
