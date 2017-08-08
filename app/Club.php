<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Club extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'name_short', 'name_code',
        'founded', 'league_entry', 'league_exit',
        'colours_club_primary', 'colours_club_secondary',
        'colours_kit_home_primary', 'colours_kit_home_secondary',
        'colours_kit_away_primary', 'colours_kit_away_secondary',
        'website', 'facebook',
        'note', 'is_real_club', 'published'
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
        'name', 'name_short', 'name_code',
        'founded', 'league_entry', 'league_exit',
        'colours_club_primary', 'colours_club_secondary',
        'colours_kit_home_primary', 'colours_kit_home_secondary',
        'colours_kit_away_primary', 'colours_kit_away_secondary',
        'website', 'facebook',
        'note', 'is_real_club', 'published'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'founded', 'league_entry', 'league_exit'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope a query to only include hobby clubs
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsNotRealClub($query)
    {
        return $query->where('is_real_club','0');
    }

    /**
     * Scope a query to only include real clubs
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsRealClub($query)
    {
        return $query->where('is_real_club','1');
    }

    /***********************************************************
     * ACCESSORS
     ************************************************************/

    // TODO: USE THESE TO BUILD THE TABLE LATER!
    // USE SCOPES FOR FIXTURES AND PARAMETERS FOR SEASON OR MATCHWEEK?
    public function getTRankAttribute()
    {
        return 0;
    }

    public function getTGamesPlayedAttribute()
    {
        return $this->fixtures()->finishedRated()->get()->merge($this->fixtures()->finishedReal()->get())->count();
    }

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * @param $fixtures
     * @return int
     */
    public function getGamesPlayed($fixtures)
    {
        $gamesplayed = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->isFinished()) {
                // increment if fixture has result
                $gamesplayed++;
            }
        }

        return $gamesplayed;
    }

    /**
     * Get the club's rank of a given matchweek
     * TODO: Shit! use proper accessors!!
     * @param Matchweek $matchweek
     * @return int rank
     */
    public function getRankOfMatchweek(Matchweek $matchweek)
    {
        $season = $matchweek->season;

        $rank = $season->generateTable($matchweek)->where("id", $this->id)->pluck('t_rank')->first();

        return $rank;
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A club has many players
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * A club is related to many seasons
     * A season is related to many clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'clubs_seasons')
            ->withPivot('rank', 'deduction_points', 'deduction_goals', 'withdrawal', 'note')
            ->withTimestamps();
    }

    /**
     * A club can be related to one or more stadiums
     * A stadium can be related to one or more clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stadiums()
    {
        return $this->belongsToMany(Stadium::class, 'clubs_stadiums')
            ->withPivot('regular_home_day', 'regular_home_time', 'note', 'is_regular_stadium')
            ->withTimestamps();
    }

    /**
     * Return all home fixtures
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixturesHome()
    {
        return $this->hasMany(Fixture::class, 'club_id_home');
    }

    /**
     * Return all away fixtures
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixturesAway()
    {
        return $this->hasMany(Fixture::class, 'club_id_away');
    }

    /**
     * Return all fixtures the club is related to
     * @return mixed
     */
    public function fixtures()
    {
        $fixtures = $this->fixturesHome->merge($this->fixturesAway);

        return $fixtures;
    }

    public function reschedulings()
    {
        return $this->hasMany(Fixture::class, 'rescheduled_by_club');
    }
}
