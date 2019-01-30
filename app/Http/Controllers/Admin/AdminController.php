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

        // Fixtures in the next two weeks
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->addWeek()->endOfWeek();
        $today = Carbon::now();
        $fixtures_this_week = Fixture::whereBetween('datetime', [$monday, $sunday])
            ->notCancelled()
            ->orderBy('datetime')
            ->with([
                'matchweek.season',
                'clubHome',
                'clubAway',
                'referees'
            ])
            ->get();


        // Fixtures without referee, get them for the next 30 days
        $in_thirty_days = Carbon::now()->addDays(30);
        $fixtures_without_referee = Fixture::whereBetween('datetime', [$today, $in_thirty_days])
            ->notCancelled()
            ->doesntHave('referees')
            ->orderBy('datetime')
            ->with([
                'matchweek.season',
                'clubHome',
                'clubAway',
                'referees'
            ])
            ->get();

        // Previous fixtures without result
        $fixtures_without_result = Fixture::where('datetime', '<=', $today)
            ->notPlayedOrRated()
            ->notCancelled()
            ->doesntHave('rescheduledTo')
            ->orderBy('datetime', 'desc')
            ->with([
                'matchweek.season',
                'clubHome',
                'clubAway',
                'referees'
            ])
            ->get();

        return view('admin.index', compact(
            'fixtures_this_week',
            'today',
            'monday',
            'sunday',
            'fixtures_without_result',
            'fixtures_without_referee',
            'in_thirty_days')
        );
    }

    public function docs ()
    {
        return view('admin.docs');
    }
}
