<?php

namespace HLW;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Traits\LogsActivity;

class Season extends Model
{
    use LogsActivity;

    // log attributes
    protected static $logAttributes = [
        'division_id',
        'begin', 'end',
        'season_nr',
        'champion',
        'ranks_champion', 'ranks_promotion', 'ranks_relegation',
        'playoff_champion', 'playoff_cup', 'playoff_relegation',
        'max_rescheduling',
        'rules',
        'note',
        'published'
    ];

    /**
     * Only the changed attributes should be logged
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'division_id',
        'begin', 'end',
        'season_nr',
        'champion',
        'ranks_champion', 'ranks_promotion', 'ranks_relegation',
        'playoff_champion', 'playoff_cup', 'playoff_relegation',
        'max_rescheduling',
        'rules',
        'note',
        'published'
    ];

    /**
     * The attributes that should be mutated to dates
     * @var array
     */
    protected $dates = [
        'begin', 'end'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * scope the query to the current season
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->where('begin', '<=', date('Y-m-d'))
            ->where('end', '>=', date('Y-m-d'));
    }

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * Get the current matchweek (based on the current date) of the season
     *
     * @return Matchweek
     */
    public function currentMatchweek()
    {
        $matchweeks             = $this->matchweeks;
        $end_of_last_matchweek  = $matchweeks->max('end');
        $current_date           = Carbon::now()->toDateString();
        $yesterday              = Carbon::now()->subDay(1)->toDateString();
        $current_matchweek      = null;

        foreach ($matchweeks as $matchweek) {
            // is there a matchweek for the current date?
            if ($matchweek->begin <= $current_date && $matchweek->end >= $current_date) {
                $current_matchweek = $matchweek;
                break;
            } elseif ($matchweek->end == $yesterday) { // was there a matchweek yesterday?
                $current_matchweek = $matchweek;
                break;
            } elseif ($current_date < $matchweek->begin) { // else give me the next matchweek
                $current_matchweek = $matchweek;
                break;
            } elseif ($current_date > $matchweek->end && $matchweek->end == $end_of_last_matchweek) { // else give me the last matchweek
                $current_matchweek = $matchweek;
                break;
            }
        }

        return $current_matchweek;
    }

    /**
     * Generate the table for the current season and until the given matchweek
     * TODO: this is shit! use accessors!
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function generateTable(Matchweek $matchweek = null)
    {
        if (is_null($matchweek)) {
            $matchweek = $this->currentMatchweek();
        }

        // get all clubs assigned to this season
        $clubs = $this->clubs->sortBy('name');

        /*
         * Create initial table
         * Rank Played Won Drawn Loss GoalsFor GoalsAgainst GoalDifference Points Form...
         */
        $table = $clubs->map(function ($club) {
            $club['t_rank']         = 0;
            $club['t_played']       = 0;
            $club['t_won']          = 0;
            $club['t_drawn']        = 0;
            $club['t_lost']         = 0;
            $club['t_goals_for']    = 0;
            $club['t_goals_against']= 0;
            $club['t_goals_diff']   = 0;
            $club['t_points']       = 0;

            return $club;
        });

        // #1 Collect the data
        foreach ($table as $club) {
            // only clubs that have not withdrawn from the competition
            if (!$club->pivot->withdrawal) {
                // get all played fixtures of the current club of this season
                // count only fixtures where related clubs have not withdrawn from the competition -> notCancelled
                $club_fixtures_played = $this->fixtures()->played()->notCancelled()->ofClub($club->id)->get();
                // get all rated fixtures ""
                $club_fixtures_rated  = $this->fixtures()->rated()->notCancelled()->ofClub($club->id)->get();
                // merge
                $club_fixtures = $club_fixtures_played->merge($club_fixtures_rated)->sortBy('matchweek.number_consecutive');

                foreach ($club_fixtures as $fixture) {
                    // aggregate values only until current matchweek
                    if ($fixture->matchweek->number_consecutive <= $matchweek->number_consecutive) {
                        // increment games played
                        $club->t_played++;
                        // won, drawn, loss, points
                        // not rated
                        if($fixture->isPlayed() && !$fixture->isRated()){
                            if ($club->id == $fixture->club_id_home && ($fixture->goals_home > $fixture->goals_away)
                                || $club->id == $fixture->club_id_away && ($fixture->goals_home < $fixture->goals_away)) {
                                $club->t_won++;
                                $club->t_points += 3;
                            } elseif ($fixture->goals_home == $fixture->goals_away) {
                                $club->t_drawn++;
                                $club->t_points += 1;
                            } else {
                                $club->t_lost++;
                            }
                            // goals for and against
                            if ($club->id == $fixture->club_id_home) {
                                $club->t_goals_for += $fixture->goals_home;
                                $club->t_goals_against += $fixture->goals_away;
                            } elseif ($club->id == $fixture->club_id_away) {
                                $club->t_goals_for += $fixture->goals_away;
                                $club->t_goals_against += $fixture->goals_home;
                            }
                        } elseif ($fixture->isRated()) { // rated match
                            if ($club->id == $fixture->club_id_home && ($fixture->goals_home_rated > $fixture->goals_away_rated)
                                || $club->id == $fixture->club_id_away && ($fixture->goals_home_rated < $fixture->goals_away_rated)) {
                                $club->t_won++;
                                $club->t_points += 3;
                            } elseif ($fixture->goals_home_rated == $fixture->goals_away_rated) {
                                $club->t_drawn++;
                                $club->t_points += 1;
                            } else {
                                $club->t_lost++;
                            }
                            // goals for and against
                            if ($club->id == $fixture->club_id_home) {
                                $club->t_goals_for += $fixture->goals_home_rated;
                                $club->t_goals_against += $fixture->goals_away_rated;
                            } elseif ($club->id == $fixture->club_id_away) {
                                $club->t_goals_for += $fixture->goals_away_rated;
                                $club->t_goals_against += $fixture->goals_home_rated;
                            }
                        }

                    }
                }
                // goals difference
                $club->t_goals_diff = $club->t_goals_for - $club->t_goals_against;
                // #2 Apply season parameters contained in pivot
                // points deduction
                $club->t_points -= $club->pivot->deduction_points;
                // goals deduction
                $club->t_goals_for -= $club->pivot->deduction_goals;
            }
        }

        // #3 Sort the table, use values() on collection
        $table_sorted = $table->sort( function($a, $b) {
            $result = false;

            // compare points
            if ($b->t_points > $a->t_points) {
                $result = true;
            } elseif ($b->t_points == $a->t_points) {               // if points are equal
                if ($b->t_goals_diff > $a->t_goals_diff) {          // compare goal difference
                    $result = true;
                } elseif ($b->t_goals_diff == $a->t_goals_diff) {   // if goal difference is equal
                    if ($b->t_goals_for > $a->t_goals_for) {        // compare goals for
                        $result = true;
                    }
                }
            }

            return $result;

        })->values();

        // #4 calculate the rank
        $rank = 1;
        foreach ($table_sorted as $index => $club) {
            // first iteration
            if ($index === 0) {
                $club->t_rank = $rank;
                continue;
            }

            // break if only one item
            if ($table_sorted->count() == 1) {
                break;
            }

            // compare with previous club
            $club_previous = $table_sorted->get(--$index);
            // points
            if ($club->t_points < $club_previous->t_points) {
                $rank++;
                $club->t_rank = $rank;
                continue;
            } elseif ($club->t_points == $club_previous->t_points) {
                // equal points, then compare if goals difference smaller
                // equal goals diff, then compare goals for
                if ($club->t_goals_diff < $club_previous->t_goals_diff) {
                    $rank++;
                    $club->t_rank = $rank;
                    continue;
                } elseif (($club->t_goals_diff == $club_previous->t_goals_diff)
                    && ($club->t_goals_for < $club_previous->t_goals_for)) {
                        $rank++;
                        $club->t_rank = $rank;
                        continue;
                } else {
                    $club->t_rank = $rank;
                    continue;
                }
            }
        }

        return $table_sorted;
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A season belongs to one division
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * A season has one or many matchweeks, always order by number_consecutive
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matchweeks()
    {
        return $this->hasMany(Matchweek::class)->orderBy('number_consecutive');
    }

    /**
     * A season has many fixtures through its matchweeks
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function fixtures()
    {
        return $this->hasManyThrough(Fixture::class, Matchweek::class);
    }

    /**
     * A season is related to many clubs, a club can be related to many seasons
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'clubs_seasons')
            ->withPivot('rank', 'deduction_points', 'deduction_goals', 'withdrawal', 'note')
            ->withTimestamps();

    }
}
