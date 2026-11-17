<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Division;
use HLW\Http\Controllers\Controller;
use HLW\Support\DivisionStatistics;
use Illuminate\Http\Request;

/**
 * Scorers and sinners of a division for the admins. On the public site they are
 * only shown when personal data is public, see config/hlw.php.
 */
class StatisticsController extends Controller
{
    public function scorers(Request $request, Division $division)
    {
        $season = DivisionStatistics::season($division, $request->season_id);
        $scorers = DivisionStatistics::scorers($season);

        return view('admin.statistics.scorers', compact('division', 'season', 'scorers'));
    }

    public function sinners(Request $request, Division $division)
    {
        $season = DivisionStatistics::season($division, $request->season_id);
        [$cards, $cards_from_other_season_or_division] = DivisionStatistics::sinners($division, $season);
        $lifetime_bans = DivisionStatistics::lifetimeBans();

        return view('admin.statistics.sinners', compact('division', 'season', 'cards', 'cards_from_other_season_or_division', 'lifetime_bans'));
    }
}
