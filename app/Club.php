<?php

namespace HLW;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Club
 * TODO: rethink rescheduled matches, also consider using published and cancelled scopes and so on for fixture functions
 * @property int $id
 * @property string $name
 * @property string|null $name_short
 * @property string|null $name_code
 * @property string|null $logo_url
 * @property string|null $cover_url
 * @property \Carbon\Carbon|null $founded
 * @property \Carbon\Carbon|null $league_entry
 * @property \Carbon\Carbon|null $league_exit
 * @property string|null $colours_club_primary
 * @property string|null $colours_club_secondary
 * @property string|null $colours_kit_home_primary
 * @property string|null $colours_kit_home_secondary
 * @property string|null $colours_kit_away_primary
 * @property string|null $colours_kit_away_secondary
 * @property string|null $website
 * @property string|null $facebook
 * @property string|null $note
 * @property bool $is_real_club
 * @property bool $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Contact[] $contacts
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Fixture[] $fixturesAway
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Fixture[] $fixturesHome
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Player[] $players
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Fixture[] $reschedulings
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Season[] $seasons
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Stadium[] $stadiums
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club isNotRealClub()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club isRealClub()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereColoursClubPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereColoursClubSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereColoursKitAwayPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereColoursKitAwaySecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereColoursKitHomePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereColoursKitHomeSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereFounded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereIsRealClub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereLeagueEntry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereLeagueExit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereNameCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereNameShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Club whereWebsite($value)
 */
class Club extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name',
        'name_short',
        'name_code',
        'founded',
        'league_entry',
        'league_exit',
        'colours_club_primary',
        'colours_club_secondary',
        'colours_kit_home_primary',
        'colours_kit_home_secondary',
        'colours_kit_away_primary',
        'colours_kit_away_secondary',
        'website',
        'facebook',
        'note',
        'is_real_club',
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
        'name',
        'name_short',
        'name_code',
        'founded',
        'league_entry',
        'league_exit',
        'colours_club_primary',
        'colours_club_secondary',
        'colours_kit_home_primary',
        'colours_kit_home_secondary',
        'colours_kit_away_primary',
        'colours_kit_away_secondary',
        'website',
        'facebook',
        'note',
        'is_real_club',
        'published'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'founded', 'league_entry', 'league_exit'
    ];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'is_real_club'  => 'boolean',
        'published'     => 'boolean'
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

    /**
     * Scope a query to published clubs
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * Scope a query to clubs that are still part of the leagues
     * @param $query
     * @return mixed
     */
    public function scopeNotResigned($query)
    {
        return $query->whereNull('league_exit');
    }

    /**
     * Scope a query to resigned clubs
     * @param $query
     * @return mixed
     */
    public function scopeResigned($query)
    {
        return $query->whereNotNull('league_exit');
    }

    /***********************************************************
     * ACCESSORS
     ************************************************************/



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
        $games_played = Fixture::played()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        return $games_played;
    }

    /**
     * Get the games this club has played at home
     * Optional: for a given season
     * Optional: for a given season until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played = Fixture::played()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        return $games_played;
    }

    /**
     * Get the games this club has played at home
     * Optional: for a given season
     * Optional: for a given season until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played = Fixture::played()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

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
        $games_rated = Fixture::rated()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        return $games_rated;
    }

    /**
     * Get the home games that were rated
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated = Fixture::rated()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        return $games_rated;
    }

    /**
     * Get the away games that were rated
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated = Fixture::rated()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        return $games_rated;
    }

    /**
     * Get the games that were played (not rated) and won by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedWon(Season $season = null, Matchweek $matchweek = null)
    {
        $games_won = Fixture::played()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home', '>', 'goals_away')
                    ->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_home', '<', 'goals_away');
            })
            ->get();

        return $games_won;
    }

    /**
     * Get the games that were played (not rated) and won at home by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedWonHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_won = Fixture::played()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home', '>', 'goals_away');
            })
            ->get();

        return $games_won;
    }

    /**
     * Get the games that were played (not rated) and won at home by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedWonAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_won = Fixture::played()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_away', $this->id)
                    ->whereColumn('goals_away', '>', 'goals_home');
            })
            ->get();

        return $games_won;
    }

    /**
     * Get the games that were rated and won by club in this way
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedWon(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_won = Fixture::rated()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '>', 'goals_away_rated')
                    ->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_home_rated', '<', 'goals_away_rated');
            })
            ->get();

        return $games_rated_won;
    }

    /**
     * Get the games that were rated and won at home by club in this way
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedWonHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_won = Fixture::rated()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '>', 'goals_away_rated');
            })
            ->get();

        return $games_rated_won;
    }

    /**
     *  Get the games that were rated and won away by club in this way
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedWonAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_won = Fixture::rated()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_away', $this->id)
                    ->whereColumn('goals_away_rated', '>', 'goals_home_rated');
            })
            ->get();

        return $games_rated_won;
    }


    /**
     * Get the games that were played (not rated) and ended in a draw
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedDrawn(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played_drawn = Fixture::played()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home', '=', 'goals_away')
                    ->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_home', '=', 'goals_away');
            })
            ->get();

        return $games_played_drawn;
    }

    /**
     * Get the games that were played (not rated) and ended in a draw at home
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedDrawnHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played_drawn = Fixture::played()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home', '=', 'goals_away');
            })
            ->get();

        return $games_played_drawn;
    }

    /**
     * Get the games that were played (not rated) and ended in a draw away
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedDrawnAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played_drawn = Fixture::played()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_away', $this->id)
                    ->whereColumn('goals_home', '=', 'goals_away');
            })
            ->get();

        return $games_played_drawn;
    }

    /**
     * Get the games that were rated as a draw
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedDrawn(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_drawn = Fixture::rated()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->orWhere('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '=', 'goals_away_rated')
                    ->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_home_rated', '=', 'goals_away_rated');
            })
            ->get();

        return $games_rated_drawn;
    }

    /**
     * Get the games that were rated as a draw at home
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedDrawnHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_drawn = Fixture::rated()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->orWhere('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '=', 'goals_away_rated');
            })
            ->get();

        return $games_rated_drawn;
    }

    /**
     * Get the games that were rated as a draw away
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedDrawnAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_drawn = Fixture::rated()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->orWhere('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '=', 'goals_away_rated');
            })
            ->get();

        return $games_rated_drawn;
    }

    /**
     * TODO: rework nested wheres (game lost but rated for)
     * Get the games that were lost by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedLost(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played_lost = Fixture::played()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home', '<', 'goals_away')
                    ->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_home', '>', 'goals_away');
            })
            ->get();

        return $games_played_lost;
    }

    /**
     * Get the games that were lost by the club at home
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedLostHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played_lost = Fixture::played()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_home', $this->id)
                    ->whereColumn('goals_home', '<', 'goals_away');
            })
            ->get();

        return $games_played_lost;
    }

    /**
     * Get the games that were lost by the club away
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesPlayedLostAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_played_lost = Fixture::played()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->where('club_id_away', $this->id)
                    ->whereColumn('goals_away', '<', 'goals_home');
            })
            ->get();

        return $games_played_lost;
    }

    /**
     * Get the games that were lost by rating
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedLost(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_lost = Fixture::rated()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->orWhere('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '<', 'goals_away_rated')
                    ->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_home_rated', '>', 'goals_away_rated');
            })
            ->get();

        return $games_rated_lost;
    }

    /**
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedLostHome(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_lost = Fixture::rated()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->orWhere('club_id_home', $this->id)
                    ->whereColumn('goals_home_rated', '<', 'goals_away_rated');
            })
            ->get();

        return $games_rated_lost;
    }

    /**
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getGamesRatedLostAway(Season $season = null, Matchweek $matchweek = null)
    {
        $games_rated_lost = Fixture::rated()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->where( function($query) {
                return $query->orWhere('club_id_away', $this->id)
                    ->whereColumn('goals_away_rated', '<', 'goals_home_rated');
            })
            ->get();

        return $games_rated_lost;
    }

    /**
     * Get the number of goals that were scored by the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGoalsFor(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

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

    /**
     * Get the number of goals that were scored by the club at home
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGoalsForHome(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        $goals_for = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->club_id_home == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_for += $fixture->goals_home;
                } else {
                    $goals_for += $fixture->goals_home_rated;
                }
            }
        }

        return $goals_for;
    }

    /**
     * Get the number of goals that were scored by the club away
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGoalsForAway(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        $goals_for = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->club_id_away == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_for += $fixture->goals_away;
                } else {
                    $goals_for += $fixture->goals_away_rated;
                }
            }
        }

        return $goals_for;
    }

    /**
     * Get the number of goals that were scored against the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGoalsAgainst(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClub($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        $goals_against = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->club_id_home == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_against += $fixture->goals_away;
                } else {
                    $goals_against += $fixture->goals_away_rated;
                }
            } elseif ($fixture->club_id_away == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_against += $fixture->goals_home;
                } else {
                    $goals_against += $fixture->goals_home_rated;
                }
            }
        }

        return $goals_against;
    }

    /**
     * Get the number of goals that were scored against the club at home
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGoalsAgainstHome(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClubHome($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        $goals_against = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->club_id_home == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_against += $fixture->goals_away;
                } else {
                    $goals_against += $fixture->goals_away_rated;
                }
            }
        }

        return $goals_against;
    }

    /**
     * Get the number of goals that were scored against the club away
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getGoalsAgainstAway(Season $season = null, Matchweek $matchweek = null)
    {
        $fixtures = Fixture::playedOrRated()->notCancelled()->ofClubAway($this->id)->countsInTables()
            ->when($season, function ($query) use ($season) {
                return $query->whereHas('matchweek', function ($query2) use ($season) {
                    return $query2->where('season_id', $season->id);
                });
            })
            ->when($season && $matchweek, function ($query) use ($matchweek) {
                return $query->whereHas('matchweek', function ($query3) use ($matchweek) {
                    return $query3->where('number_consecutive', '<=', $matchweek->number_consecutive);
                });
            })
            ->get();

        $goals_against = 0;

        foreach ($fixtures as $fixture) {
            if ($fixture->club_id_away == $this->id) {
                if (!$fixture->isRated()) {
                    $goals_against += $fixture->goals_home;
                } else {
                    $goals_against += $fixture->goals_home_rated;
                }
            }
        }

        return $goals_against;
    }

    /**
     * Get the number of points for the club
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return mixed
     */
    public function getPoints(Season $season = null, Matchweek $matchweek = null)
    {
        $points = $this->getGamesPlayedWon($season, $matchweek)->count() * 3
            + $this->getGamesRatedWon($season, $matchweek)->count() * 3
            + $this->getGamesPlayedDrawn($season, $matchweek)->count() * 1
            + $this->getGamesRatedDrawn($season, $matchweek)->count() * 1;

        return $points;
    }

    /**
     * Get the number of points for the club at home
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getPointsHome(Season $season = null, Matchweek $matchweek = null)
    {
        $points = $this->getGamesPlayedWonHome($season, $matchweek)->count() * 3
            + $this->getGamesRatedWonHome($season, $matchweek)->count() * 3
            + $this->getGamesPlayedDrawnHome($season, $matchweek)->count() * 1
            + $this->getGamesRatedDrawnHome($season, $matchweek)->count() * 1;

        return $points;
    }

    /**
     * Get the number of points for the club at home
     * Optional: for a given season
     * Optional: until a given matchweek
     * @param Season|null $season
     * @param Matchweek|null $matchweek
     * @return int
     */
    public function getPointsAway(Season $season = null, Matchweek $matchweek = null)
    {
        $points = $this->getGamesPlayedWonAway($season, $matchweek)->count() * 3
            + $this->getGamesRatedWonAway($season, $matchweek)->count() * 3
            + $this->getGamesPlayedDrawnAway($season, $matchweek)->count() * 1
            + $this->getGamesRatedDrawnAway($season, $matchweek)->count() * 1;

        return $points;
    }

    /**
     * Get the specified number of last games
     * @param $numberOfGames
     * @return mixed
     */
    public function getLastGames($numberOfGames)
    {
        return Fixture::ofClub($this->id)->orderBy('datetime', 'desc')
            ->where('datetime', '<=', Carbon::now())
            ->when($numberOfGames, function ($query) use ($numberOfGames){
                return $query->take($numberOfGames);
            })
            ->get();
    }

    /**
     * Get the specified number of last games that are played or rated
     * If a date is specified, return the specified number of games equal to or before that date
     * @param $numberOfGames
     * @param null $date
     * @return mixed
     */
    public function getLastGamesPlayedOrRated($numberOfGames, $date = null)
    {
        return Fixture::ofClub($this->id)->playedOrRated()->orderBy('datetime', 'desc')
            ->with([
                'clubHome',
                'clubAway'
            ])
            // if a date is given, then return the last games before that date
            ->when($date, function ($query) use ($date){
                return $query->where('datetime', '<=', $date);
            }, function ($query) {
                return $query->where('datetime', '<=', Carbon::now());
            })
            ->when($numberOfGames, function ($query) use ($numberOfGames){
                return $query->take($numberOfGames);
            })
            ->get();
    }

    /**
     * Get the specified number of next games
     * @param null $numberofgames
     * @return mixed
     */
    public function getNextGames($numberofgames = null)
    {
        return Fixture::ofClub($this->id)->orderBy('datetime')
            ->where('datetime','>=',Carbon::now())
            ->when($numberofgames, function ($query) use ($numberofgames){
                return $query->take($numberofgames);
            })
            ->get();;
    }

    /**
     * Get the specified number of next games that are played
     * If a date is specified, return the specified number of games equal to or after that date
     * @param $numberOfGames
     * @param null $date
     * @return mixed
     */
    public function getNextGamesPlayed($numberOfGames, $date = null)
    {
        return Fixture::ofClub($this->id)->played()->orderBy('datetime', 'desc')
            // if a date is given, then return the last games before that date
            ->when($date, function ($query) use ($date){
                return $query->where('datetime', '>=', $date);
            }, function ($query) {
                return $query->where('datetime', '>=', Carbon::now());
            })
            ->when($numberOfGames, function ($query) use ($numberOfGames){
                return $query->take($numberOfGames);
            })
            ->get();
    }

    /**
     * Get the specified number of next games that are played or rated
     * If a date is specified, return the specified number of games equal to or after that date
     * @param $numberOfGames
     * @param null $date
     * @return mixed
     */
    public function getNextGamesPlayedOrRated($numberOfGames, $date = null)
    {
        return Fixture::ofClub($this->id)->playedOrRated()->orderBy('datetime', 'desc')
            // if a date is given, then return the last games before that date
            ->when($date, function ($query) use ($date){
                return $query->where('datetime', '>=', $date);
            }, function ($query) {
                return $query->where('datetime', '>=', Carbon::now());
            })
            ->when($numberOfGames, function ($query) use ($numberOfGames){
                return $query->take($numberOfGames);
            })
            ->get();
    }

    /**
     * Check whether the clubs has won the specified fixture
     * @param Fixture $fixture
     * @return bool
     */
    public function hasWon(Fixture $fixture)
    {
        $won = false;

        if (!$fixture->isRated() && $fixture->isPlayed()) {
            if ($fixture->club_id_home == $this->id &&
                ($fixture->goals_home > $fixture->goals_away
                || $fixture->goals_home_11m > $fixture->goals_away_11m )) {
                $won = true;
            } elseif ($fixture->club_id_away == $this->id &&
                ($fixture->goals_home < $fixture->goals_away
                    || $fixture->goals_home_11m < $fixture->goals_away_11m )) {
                $won = true;
            }
        } elseif ($fixture->isRated()) {
            if ($fixture->club_id_home == $this->id &&
                $fixture->goals_home_rated > $fixture->goals_away_rated) {
                $won = true;
            } elseif ($fixture->club_id_away == $this->id &&
                $fixture->goals_home_rated < $fixture->goals_away_rated) {
                $won = true;
            }
        }

        return $won;
    }

    /**
     * Check whether the clubs has drawn the specified fixture
     * @param Fixture $fixture
     * @return bool
     */
    public function hasDrawn(Fixture $fixture)
    {
        $draw = false;

        if (!$fixture->isRated() && $fixture->isPlayed()) {
            if ($fixture->club_id_home == $this->id &&
                ($fixture->goals_home == $fixture->goals_away
                    || $fixture->goals_home_11m == $fixture->goals_away_11m )) {
                $draw = true;
            } elseif ($fixture->club_id_away == $this->id &&
                ($fixture->goals_home == $fixture->goals_away
                    || $fixture->goals_home_11m == $fixture->goals_away_11m )) {
                $draw = true;
            }
        } elseif ($fixture->isRated()) {
            if ($fixture->club_id_home == $this->id &&
                $fixture->goals_home_rated == $fixture->goals_away_rated) {
                $draw = true;
            } elseif ($fixture->club_id_away == $this->id &&
                $fixture->goals_home_rated == $fixture->goals_away_rated) {
                $draw = true;
            }
        }

        return $draw;
    }

    /**
     * Check whether the clubs has lost the specified fixture
     * @param Fixture $fixture
     * @return bool
     */
    public function hasLost(Fixture $fixture)
    {
        $lost = false;

        if (!$fixture->isRated() && $fixture->isPlayed()) {
            if ($fixture->club_id_home == $this->id &&
                ($fixture->goals_home < $fixture->goals_away
                    || $fixture->goals_home_11m < $fixture->goals_away_11m )) {
                $lost = true;
            } elseif ($fixture->club_id_away == $this->id &&
                ($fixture->goals_home > $fixture->goals_away
                    || $fixture->goals_home_11m > $fixture->goals_away_11m )) {
                $lost = true;
            }
        } elseif ($fixture->isRated()) {
            if ($fixture->club_id_home == $this->id &&
                $fixture->goals_home_rated < $fixture->goals_away_rated) {
                $lost = true;
            } elseif ($fixture->club_id_away == $this->id &&
                $fixture->goals_home_rated > $fixture->goals_away_rated) {
                $lost = true;
            }
        }

        return $lost;
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
     * Get the regular stadium(s) of this club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regularStadium()
    {
        return $this->stadiums()->wherePivot('is_regular_stadium', '1');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reschedulings()
    {
        return $this->hasMany(Fixture::class, 'rescheduled_by_club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function championships()
    {
        return $this->hasMany(Season::class, 'champion_id');
    }

    /**
     * A club can be favorited by many users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_clubs')->withTimestamps();
    }
}
