<?php

namespace HLW\Http\Controllers\Admin;

use Carbon\Carbon;
use HLW\Fixture;
use HLW\Division;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Collection;
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
            ->published()
            ->orderBy('datetime')
            ->with([
                'matchweek.season.division.competition',
                'clubHome',
                'clubAway',
                'referees',
                'rescheduledTo'
            ])
            ->whereHas('matchweek.season', function ($query) {
                $query->where('published', '=', '1');
            })
            ->get();

        // Fixtures without referee, get them for the next 30 days starting from monday of current week
        $in_thirty_days = Carbon::now()->addDays(30);
        $fixtures_without_referee = Fixture::whereBetween('datetime', [$monday, $in_thirty_days])
            ->notCancelled()
            ->published()
            ->doesntHave('referees')
            ->doesntHave('rescheduledTo')
            ->orderBy('datetime')
            ->with([
                'matchweek.season.division.competition',
                'clubHome',
                'clubAway',
                'referees',
                'rescheduledTo'
            ])
            ->whereHas('matchweek.season', function ($query) {
                $query->where('published', '=', '1');
            })
            ->get();

        // Previous fixtures without result, only for current year
        $fixtures_without_result = Fixture::where('datetime', '<=', $today)
            ->where('datetime', '>=', $year_start)
            ->notPlayedOrRated()
            ->notCancelled()
            ->published()
            ->doesntHave('rescheduledTo')
            ->orderBy('datetime')
            ->with([
                'matchweek.season.division.competition',
                'clubHome',
                'clubAway',
                'referees'
            ])
            ->whereHas('matchweek.season', function ($query) {
                $query->where('published', '=', '1');
            })
            ->get();

        // rescheduled fixtures "Nachholspiele"
        $fixtures_rescheduled = Fixture::whereNotNull('rescheduled_from_fixture_id')
            ->notCancelled()
            ->published()
            ->orderBy('datetime', 'desc')
            ->with([
                'matchweek.season.division.competition',
                'clubHome',
                'clubAway',
                'referees'
            ])
            ->whereHas('matchweek.season', function ($query) {
                $query->where('published', '=', '1')->where('begin', '<=', Carbon::now())
                    ->where('end', '>=', Carbon::now());
            })
            ->get();

        $can_read_club = Auth::user()->can('read club') ? true : false;
        $can_read_fixture = Auth::user()->can('read fixture') ? true : false;
        $can_update_fixture = Auth::user()->can('update fixture') ? true : false;
        $can_reschedule_fixture = Auth::user()->can('reschedule fixture') ? true : false;

        $current_seasons = Division::published()
            ->with(['seasons' => function ($query) {
                $query->published()->current();
            }])
            ->get()
            ->pluck('seasons')
            ->flatten();

        return view('admin.index', compact(
            'fixtures_this_week',
            'today',
            'monday',
            'sunday',
            'year_start',
            'fixtures_without_result',
            'fixtures_without_referee',
            'fixtures_rescheduled',
            'in_thirty_days',
            'can_read_club',
            'can_read_fixture',
            'can_update_fixture',
            'can_reschedule_fixture',
            'current_seasons')
        );
    }

    public function docs ()
    {
        return view('admin.docs');
    }
}
