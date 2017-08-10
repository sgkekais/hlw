<?php

namespace HLW;

use Carbon\Carbon;
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
    // TODO: TRY  $c->fixtures()->where('matchweek.number_consecutive','<','22')->count()
    public function getRankAttribute()
    {
        return 0;
    }

    // TODO funktioniert nicht mit Parameter
    // Könnte als Methode mit wherehas funktionieren?
    public function getGamesRatedAttribute()
    {
        return 0;
    }

    public function getGamesWonAttribute()
    {
        return 0;
    }

    public function getGamesDrawnAttribute()
    {
        return 0;
    }

    public function getGamesLostAttribute()
    {
        return 0;
    }

    public function getGoalsForAttribute()
    {
        return 0;
    }

    public function getGoalsAgainstAttribute()
    {
        return 0;
    }

    public function getGoalsDiffAttribute()
    {
        return $this->getGoalsForAttribute()-$this->getGoalsAgainstAttribute();
    }


    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * Get the games this club has played
     * Optionally for a given season
     * Optionally for a given season until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGamesPlayed(Season $season = null, Matchweek $matchweek = null)
    {
        $played_games = Fixture::played()->notCancelled()->ofClub($this->id)
            ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });

        return $played_games;
    }

    /**
     * Get the games that were rated
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRated(Season $season = null, Matchweek $matchweek = null)
    {
        $rated_games = Fixture::rated()->notCancelled()->ofClub($this->id)
            ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });

        return $rated_games;
    }

    public function getGamesWon(Season $season = null, Matchweek $matchweek = null)
    {
        $played_and_rated_games = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)
            ->where('club_id_home', $this->id)
            ->where('goals_home', '>', 'goals_away')
            ->orWhere('club_id_away', $this->id)
            ->where('goals_home', '<', 'goals_away');

        return $played_and_rated_games;
    }

    public function getLastGames($numberofgames)
    {
        return Fixture::ofClub($this->id)->orderBy('datetime', 'desc')
            ->where('datetime', '<=', Carbon::now())
            ->when($numberofgames, function ($query) use ($numberofgames){
                return $query->take($numberofgames);
            })
            ->get();
    }

    public function getNextGame()
    {
        return Fixture::ofClub($this->id)->orderBy('datetime')
            ->where('datetime','>=',Carbon::now())->first();
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
