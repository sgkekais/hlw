<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
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
            $club['t_goalsfor']     = 0;
            $club['t_goalsagainst'] = 0;
            $club['t_goaldiff']     = 0;
            $club['t_points']       = 0;

            return $club;
        });

        // collect data
        foreach ($table as $club) {
            // only clubs that have not withdrawn from the competition
            if (!$club->pivot->withdrawal) {
                // get all fixtures of the current club of this season
                foreach ($this->fixtures()->ofClub($club->id)->get()->sortBy('matchweek.number_consecutive') as $fixture) {
                    // aggregate values only until current matchweek
                    if ($fixture->matchweek->number_consecutive <= $matchweek->number_consecutive) {
                        // increment games played
                        if ($fixture->isFinished()) {
                            $club->t_played++;
                        }
                    }
                }
            }
        }


        // how to modify a value
        // $table->map(function($club){ if($club->id == 3) {$club->t_pl = 22;} return $club; });

        // cumulate table values until current matchweek is reached
        /*foreach ($this->matchweeks()->orderBy('number_consecutive')->get() as $matchweek) {
            // $table->push($matchweek);

            /*
             * für jeden Club, der nicht abgemeldet ist
             */
        //}

        return $table;

        // sorting
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
