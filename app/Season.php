<?php

namespace HLW;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Season
 *
 * @property int $id
 * @property int $division_id
 * @property \Carbon\Carbon $begin
 * @property \Carbon\Carbon $end
 * @property int|null $season_nr
 * @property int|null $champion
 * @property array $ranks_champion
 * @property array $ranks_promotion
 * @property array $ranks_relegation
 * @property array $playoff_champion
 * @property array $playoff_cup
 * @property array $playoff_relegation
 * @property int|null $max_rescheduling
 * @property string|null $rules
 * @property string|null $note
 * @property bool $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Club[] $clubs
 * @property-read \HLW\Division $division
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Fixture[] $fixtures
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Matchweek[] $matchweeks
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season current()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season published()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereChampion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereMaxRescheduling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season wherePlayoffChampion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season wherePlayoffCup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season wherePlayoffRelegation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereRanksChampion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereRanksPromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereRanksRelegation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereSeasonNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Season whereUpdatedAt($value)
 */

class Season extends Model
{
    use LogsActivity;

    // log attributes
    protected static $logAttributes = [
        'division_id', 'begin', 'end', 'season_nr', 'champion_id', 'champion_icon', 'champion_icon_color', 'ranks_champion', 'ranks_promotion', 'ranks_relegation',
        'playoff_champion', 'playoff_cup', 'playoff_relegation', 'max_rescheduling', 'rules', 'note', 'published'
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
        'division_id', 'begin', 'end', 'season_nr', 'champion_id', 'champion_icon', 'champion_icon_color', 'ranks_champion', 'ranks_promotion', 'ranks_relegation',
        'playoff_champion', 'playoff_cup', 'playoff_relegation', 'max_rescheduling', 'rules', 'note', 'published'
    ];

    /**
     * The attributes that should be mutated to dates
     * @var array
     */
    protected $dates = [
        'begin', 'end'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'published' => 'boolean'
    ];

    /***********************************************************
     * ACCESSORS
     ************************************************************/

    /**
     * Combine begin and end date into a pre-formatted 'name' attribute for the season
     * @return string
     */
    public function getNameAttribute()
    {
        // format the begin date if it is not null
        if ($this->begin) {
            $begin = $this->begin->format('Y');
        } else {
            $begin = null;
        }

        // format the end date if it is not null
        if ($this->end) {
            $end = substr($this->end->format('Y'), 2);
        } else {
            $end = null;
        }

        // return only one date if the formatted dates are equal
        if ($begin == $end) {
            return $begin;
        } else {
            return $begin . ($end ? "/" . $end : null);
        }
    }

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * scope the query to the current season
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent ($query)
    {
        return $query->where('begin', '<=', Carbon::now())
            ->where('end', '>=', Carbon::now());
    }

    /**
     * Scope a query to only return published seasons
     * @param $query
     * @return mixed
     */
    public function scopePublished ($query)
    {
        return $query->where('published', 1);
    }

    /***********************************************************
     * ACCESSORS
     ************************************************************/

    /**
     * @param $value
     * @return array
     */
    public function getRanksChampionAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getRanksPromotionAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getRanksRelegationAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getPlayoffChampionAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getPlayoffCupAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * @param $value
     * @return array
     */
    public function getPlayoffRelegationAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Return the type of the related competition
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->division->competition->type;
    }

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * Get the previous season using the season nr and division id
     * @return mixed
     */
    public function previousSeason()
    {
        $previous_season = Season::where('division_id', $this->division_id)->where('season_nr',$this->season_nr-1)->first();

        return $previous_season;
    }

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
            }
            // was there a matchweek yesterday?
            elseif ($matchweek->end == $yesterday) {
                $current_matchweek = $matchweek;
                break;
            }
            // else give me the next matchweek
            elseif ($current_date < $matchweek->begin) {
                $current_matchweek = $matchweek;
                break;
            }
            // else give me the last matchweek
            elseif ($current_date > $matchweek->end && $matchweek->end == $end_of_last_matchweek) {
                $current_matchweek = $matchweek;
                break;
            }
        }

        return $current_matchweek;
    }

    /**
     * @param Matchweek|null $matchweek
     * @param int $scope
     * @return \Illuminate\Support\Collection|static
     */
    public function generateTable (Matchweek $matchweek = null, $scope = 0) {

        // create new fields for table
        $clubs = $this->clubs()->orderBy('name')->get();
        $clubs->map(function ($club) {
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

            switch ($scope) {
                // Full table
                case 0:
                    // played + rated games
                    $club->t_played = $club->getGamesPlayed($this, $matchweek)->count() + $club->getGamesRated($this, $matchweek)->count();
                    // won games
                    $club->t_won = $club->getGamesPlayedWon($this, $matchweek)->count() + $club->getGamesRatedWon($this, $matchweek)->count();
                    // drawn games
                    $club->t_drawn = $club->getGamesPlayedDrawn($this, $matchweek)->count() + $club->getGamesRatedDrawn($this, $matchweek)->count();
                    // lost games
                    $club->t_lost = $club->getGamesPlayedLost($this, $matchweek)->count() + $club->getGamesRatedLost($this, $matchweek)->count();
                    // goals for
                    $club->t_goals_for = $club->getGoalsFor($this, $matchweek) - $club->pivot->deduction_goals;
                    // goals against
                    $club->t_goals_against = $club->getGoalsAgainst($this, $matchweek);
                    // goals diff
                    $club->t_goals_diff = $club->t_goals_for - $club->t_goals_against;
                    // points
                    $club->t_points    = $club->t_won * 3 + $club->t_drawn * 1 - $club->pivot->deduction_points;

                    break;
                // Home table
                case 1:
                    // played + rated games
                    $club->t_played = $club->getGamesPlayedHome($this, $matchweek)->count() + $club->getGamesRatedHome($this, $matchweek)->count();
                    // won games
                    $club->t_won = $club->getGamesPlayedWonHome($this, $matchweek)->count() + $club->getGamesRatedWonHome($this, $matchweek)->count();
                    // drawn games
                    $club->t_drawn = $club->getGamesPlayedDrawnHome($this, $matchweek)->count() + $club->getGamesRatedDrawnHome($this, $matchweek)->count();
                    // lost games
                    $club->t_lost = $club->getGamesPlayedLostHome($this, $matchweek)->count() + $club->getGamesRatedLostHome($this, $matchweek)->count();
                    // goals for
                    $club->t_goals_for = $club->getGoalsForHome($this, $matchweek) - $club->pivot->deduction_goals;
                    // goals against
                    $club->t_goals_against = $club->getGoalsAgainstHome($this, $matchweek);
                    // goals diff
                    $club->t_goals_diff = $club->t_goals_for - $club->t_goals_against;
                    // points
                    $club->t_points    = $club->t_won * 3 + $club->t_drawn * 1 - $club->pivot->deduction_points;

                    break;
                // Away table
                case 2:
                    // played + rated games
                    $club->t_played = $club->getGamesPlayedAway($this, $matchweek)->count() + $club->getGamesRatedAway($this, $matchweek)->count();
                    // won games
                    $club->t_won = $club->getGamesPlayedWonAway($this, $matchweek)->count() + $club->getGamesRatedWonAway($this, $matchweek)->count();
                    // drawn games
                    $club->t_drawn = $club->getGamesPlayedDrawnAway($this, $matchweek)->count() + $club->getGamesRatedDrawnAway($this, $matchweek)->count();
                    // lost games
                    $club->t_lost = $club->getGamesPlayedLostAway($this, $matchweek)->count() + $club->getGamesRatedLostAway($this, $matchweek)->count();
                    // goals for
                    $club->t_goals_for = $club->getGoalsForAway($this, $matchweek) - $club->pivot->deduction_goals;
                    // goals against
                    $club->t_goals_against = $club->getGoalsAgainstAway($this, $matchweek);
                    // goals diff
                    $club->t_goals_diff = $club->t_goals_for - $club->t_goals_against;
                    // points
                    $club->t_points    = $club->t_won * 3 + $club->t_drawn * 1 - $club->pivot->deduction_points;

                    break;
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

    /**
     * @return bool
     */
    public function isFinished()
    {
       return $this->champion ? true : false;
    }

    /**
     * Return all cards of the season
     * @return array
     */
    public function cards()
    {
        $cards = collect();

        foreach ($this->matchweeks as $matchweek) {
            foreach ($matchweek->fixtures as $fixture) {
                if (!$fixture->cards->isEmpty()) {
                    foreach ($fixture->cards->load(['fixture', 'player']) as $card) {
                        $cards->push($card);
                    }
                }
            }
        }

        return $cards;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function goals()
    {
        $goals = collect();

        foreach ($this->matchweeks as $matchweek) {
            foreach ($matchweek->fixtures as $fixture) {
                if (!$fixture->goals->isEmpty() && !$fixture->isCancelled() && !$fixture->isRated()) {
                    foreach ($fixture->goals->load(['fixture', 'player']) as $goal) {
                        $goals->push($goal);
                    }
                }
            }
        }

        return $goals;
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

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function champion()
    {
        return $this->belongsTo(Club::class, 'champion_id');
    }
}
