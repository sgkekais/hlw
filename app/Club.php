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
    public function getRankAttribute()
    {
        return 0;
    }

    public function getGamesPlayedAttribute()
    {
        return 0;
    }

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
     * Optional: for a given season
     * Optional: for a given season until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGamesPlayed(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played = Fixture::played()->notCancelled()->ofClub($this->id)
            ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });

        return $games_played;
    }

    /**
     * Get the games that were rated
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRated(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated = Fixture::rated()->notCancelled()->ofClub($this->id)
            ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });

        return $games_rated;
    }

    /**
     * Get the games that were won by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesWon(Season $season = null, Matchweek $matchweek = null)
    {
        $games_won = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)
            ->where('club_id_home', $this->id)
            ->whereColumn('goals_home', '>', 'goals_away')
            ->orWhere('club_id_home', $this->id)
            ->whereColumn('goals_home_rated', '>', 'goals_away_rated')
            ->orWhere('club_id_away', $this->id)
            ->whereColumn('goals_home', '<', 'goals_away')
            ->orWhere('club_id_away', $this->id)
            ->whereColumn('goals_home_rated', '<', 'goals_away_rated')
        ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });;

        return $games_won;
    }

    /**
     * Get the games that ended in a draw
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesDrawn(Season $season = null, Matchweek $matchweek = null)
    {
        $games_drawn = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)
            ->where('club_id_home', $this->id)
            ->whereColumn('goals_home', '=', 'goals_away')
            ->orWhere('club_id_home', $this->id)
            ->whereColumn('goals_home_rated', '=', 'goals_away_rated')
            ->orWhere('club_id_away', $this->id)
            ->whereColumn('goals_home', '=', 'goals_away')
            ->orWhere('club_id_away', $this->id)
            ->whereColumn('goals_home_rated', '=', 'goals_away_rated')
            ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });;

        return $games_drawn;
    }

    /**
     * Get the games that were lost by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesLost(Season $season = null, Matchweek $matchweek = null)
    {
        $games_lost = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)
            ->where('club_id_home', $this->id)
            ->whereColumn('goals_home', '<', 'goals_away')
            ->orWhere('club_id_home', $this->id)
            ->whereColumn('goals_home_rated', '<', 'goals_away_rated')
            ->orWhere('club_id_away', $this->id)
            ->whereColumn('goals_home', '>', 'goals_away')
            ->orWhere('club_id_away', $this->id)
            ->whereColumn('goals_home_rated', '>', 'goals_away_rated')
            ->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });

        return $games_lost;
    }

    public function getGoalsFor(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)->get()
            ->when($season, function ($query) use ($season) {
                return $query->where('matchweek.season_id', $season->id);
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->where('matchweek.number_consecutive', '<=', $matchweek->number_consecutive);
            });

        $goals_for = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->club_id_home == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_for += $fixture->goals_home;
                } else {
                    $goals_for += $fixture->goals_home_rated;
                }
            } elseif ($fixture->club_id_away == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_for += $fixture->goals_away;
                } else {
                    $goals_for += $fixture->goals_away_rated;
                }
            }
        }

        return $goals_for;
    }

    public function getGoalsAgainst(Season $season = null, Matchweek $matchweek = null)
    {

    }

    public function getPoints(Season $season = null, Matchweek $matchweek = null)
    {
        $points = $this->getGamesWon($season, $matchweek)->count() * 3
            + $this->getGamesDrawn($season, $matchweek)->count() *1;

        return $points;
    }

    /**
     * Get the specified number of last games
     * @param $numberofgames
     * @return mixed
     */
    public function getLastGames($numberofgames)
    {
        return Fixture::ofClub($this->id)->orderBy('datetime', 'desc')
            ->where('datetime', '<=', Carbon::now())
            ->when($numberofgames, function ($query) use ($numberofgames){
                return $query->take($numberofgames);
            })
            ->get();
    }

    /**
     * Get the specified number of next games
     * @return mixed
     */
    public function getNextGames($numberofgames)
    {
        return Fixture::ofClub($this->id)->orderBy('datetime')
            ->where('datetime','>=',Carbon::now())
            ->when($numberofgames, function ($query) use ($numberofgames){
                return $query->take($numberofgames);
            })
            ->get();;
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
