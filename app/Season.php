<?php

namespace HLW;

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

    public function generateTable(Matchweek $matchweek = null)
    {
        // TODO: change current scope so that it also returns the first, next or the last matchweek depending on the current date
        if (!$matchweek) {
            $matchweek = $this->matchweeks()->current()->first();
        }

        // get all clubs assigned to this season
        $clubs = $this->clubs;

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
                // count only fixtures where related clubs have not withdrawn from the competition
                foreach ($this->fixtures()->finished()->notCancelled()->ofClub($club->id)->get()->sortBy('matchweek.number_consecutive') as $fixture) {
                    // aggregate values only until current matchweek
                    if ($fixture->matchweek->number_consecutive <= $matchweek->number_consecutive) {
                        // increment games played
                        $club->t_played++;
                        // won, drawn, loss, points
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

        // #3 Sort the table

        return $table;
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
