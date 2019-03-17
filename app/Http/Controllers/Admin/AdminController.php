<?php

namespace HLW\Http\Controllers\Admin;

use Carbon\Carbon;
use HLW\Fixture;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        // TODO: Rollenbasiertes Dashboard?

        // Fixtures in the next two weeks
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->addWeek()->endOfWeek();
        $today = Carbon::now();
        $year_start = Carbon::now()->startOfYear();
        $fixtures_this_week = Fixture::whereBetween('datetime', [$monday, $sunday])
            ->notCancelled()
            ->orderBy('datetime')
            ->with([
                'matchweek.season',
                'clubHome',
                'clubAway',
                'referees',
                'rescheduledTo'
            ])
            ->get();


        // Fixtures without referee, get them for the next 30 days starting from monday of current week
        $in_thirty_days = Carbon::now()->addDays(30);
        $fixtures_without_referee = Fixture::whereBetween('datetime', [$monday, $in_thirty_days])
            ->notCancelled()
            ->doesntHave('referees')
            ->orderBy('datetime')
            ->with([
                'matchweek.season',
                'clubHome',
                'clubAway',
                'referees',
                'rescheduledTo'
            ])
            ->get();

        // Previous fixtures without result, only for current year
        $fixtures_without_result = Fixture::where('datetime', '<=', $today)
            ->where('datetime', '>=', $year_start)
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

        $can_read_club = Auth::user()->can('read club') ? true : false;
        $can_read_fixture = Auth::user()->can('read fixture') ? true : false;
        $can_update_fixture = Auth::user()->can('update fixture') ? true : false;
        $can_reschedule_fixture = Auth::user()->can('reschedule fixture') ? true : false;

        return view('admin.index', compact(
            'fixtures_this_week',
            'today',
            'monday',
            'sunday',
            'year_start',
            'fixtures_without_result',
            'fixtures_without_referee',
            'in_thirty_days',
            'can_read_club',
            'can_read_fixture',
            'can_update_fixture',
            'can_reschedule_fixture')
        );
    }

    public function docs ()
    {
        return view('admin.docs');
    }
}
