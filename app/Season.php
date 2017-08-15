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

        $clubs = $this->clubs()->orderBy('name')->get()->map(function ($club) {
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

        // collect table data
        foreach ($clubs as $club) {
            // only clubs that have not withdrawn from the competition
            if (!$club->pivot->withdrawal) {
                // played + rated games
                $club->t_played = $club->getGamesPlayed($this, $matchweek)->count()+$club->getGamesRated($this, $matchweek)->count();
                // won games
                $club->t_won = $club->getGamesPlayedWon($this, $matchweek)->count() + $club->getGamesRatedWon($this, $matchweek)->count();
                // drawn games
                $club->t_drawn = $club->getGamesPlayedDrawn($this, $matchweek)->count() + $club->getGamesRatedDrawn($this, $matchweek)->count();
                // lost games
                $club->t_lost = $club->getGamesPlayedLost($this, $matchweek)->count() + $club->getGamesRatedLost($this, $matchweek)->count();
                // goals for
                $club->t_goals_for = $club->getGoalsFor($this, $matchweek);
                // goals against
                $club->t_goals_against = $club->getGoalsAgainst($this, $matchweek);
                // goals diff
                $club->t_goals_diff = $club->t_goals_for - $club->t_goals_against;
                // points
                $club->t_points    = $club->t_won * 3 + $club->t_drawn * 1;
            }
        }

        // #3 Sort the table, use values() on collection
        $clubs = $clubs->sort( function($a, $b) {
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
        foreach ($clubs as $index => $club) {
            // first iteration
            if ($index === 0) {
                $club->t_rank = $rank;
                continue;
            }

            // break if only one item
            if ($clubs->count() == 1) {
                break;
            }

            // compare with previous club
            $club_previous = $clubs->get(--$index);
            // points
            if ($club->t_points < $club_previous->t_points) {
                $rank++;
                if ($rank < $index+2) {
                    $rank = $index+2;
                }
                $club->t_rank = $rank;
                continue;
            } elseif ($club->t_points == $club_previous->t_points) {
                // equal points, then compare if goals difference smaller
                // equal goals diff, then compare goals for
                if ($club->t_goals_diff < $club_previous->t_goals_diff) {
                    $rank++;
                    if ($rank < $index+2) {
                        $rank = $index+2;
                    }
                    $club->t_rank = $rank;
                    continue;
                } elseif (($club->t_goals_diff == $club_previous->t_goals_diff)
                    && ($club->t_goals_for < $club_previous->t_goals_for)) {
                    $rank++;
                    if ($rank < $index+2) {
                        $rank = $index+2;
                    }
                    $club->t_rank = $rank;
                    continue;
                } else {
                    $club->t_rank = $rank;
                    continue;
                }
            }
        }

        return $clubs;
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
