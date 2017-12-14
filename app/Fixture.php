<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Fixture
 *
 * @property int $id
 * @property int $matchweek_id
 * @property \Carbon\Carbon|null $datetime
 * @property int|null $stadium_id
 * @property int|null $club_id_home
 * @property int|null $club_id_away
 * @property int|null $goals_home
 * @property int|null $goals_away
 * @property int|null $goals_home_11m
 * @property int|null $goals_away_11m
 * @property int|null $goals_home_rated
 * @property int|null $goals_away_rated
 * @property string|null $rated_note
 * @property string|null $note
 * @property bool $cancelled
 * @property bool $published
 * @property int|null $rescheduled_from_fixture_id
 * @property int|null $rescheduled_by_club
 * @property string|null $reschedule_reason
 * @property int $reschedule_count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Card[] $cards
 * @property-read \HLW\Club|null $clubAway
 * @property-read \HLW\Club|null $clubHome
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Goal[] $goals
 * @property-read \HLW\Matchweek $matchweek
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Referee[] $referees
 * @property-read \HLW\Club|null $rescheduledBy
 * @property-read \HLW\Fixture|null $rescheduledFrom
 * @property-read \HLW\Fixture $rescheduledTo
 * @property-read \HLW\Stadium|null $stadium
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture ofClub($clubid)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture ofClubAway($clubid)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture ofClubHome($clubid)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture played()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture playedOrRated()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture published()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture rated()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture rescheduledByClub($clubid)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereClubIdAway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereClubIdHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereGoalsAway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereGoalsAway11m($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereGoalsAwayRated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereGoalsHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereGoalsHome11m($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereGoalsHomeRated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereMatchweekId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereRatedNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereRescheduleCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereRescheduleReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereRescheduledByClub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereRescheduledFromFixtureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereStadiumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Fixture whereUpdatedAt($value)
 */

class Fixture extends Model
{
    /*
     * TODO fixture ended in penalty shoot-out?
     * TODO fixture was rated?
     */

    use LogsActivity;

    /**
     * The attributes that should be logged
     * @var array
     */
    protected static $logAttributes = [
        'datetime',
        'stadium_id',
        'club_id_home',
        'club_id_away',
        'goals_home',
        'goals_away',
        'goals_home_11m',
        'goals_away_11m',
        'goals_home_rated', 'goals_away_rated', 'rated_note',
        'note',
        'cancelled',
        'published',
        'rescheduled_from_fixture_id', 'rescheduled_by_club', 'reschedule_reason', 'reschedule_count'
    ];

    /**
     * Only the changed attributes should be logged
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'datetime',
        'stadium_id',
        'club_id_home',
        'club_id_away',
        'goals_home',
        'goals_away',
        'goals_home_11m',
        'goals_away_11m',
        'goals_home_rated', 'goals_away_rated', 'rated_note',
        'note',
        'cancelled',
        'published',
        'rescheduled_from_fixture_id', 'rescheduled_by_club', 'reschedule_reason', 'reschedule_count'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'datetime'
    ];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'cancelled' => 'boolean',
        'published' => 'boolean'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope fixtures to a specific club
     * @param Builder $query
     * @param $clubid
     * @return mixed
     */
    public function scopeOfClub($query, $clubid)
    {
        return $query->where('club_id_home', $clubid)
            ->orWhere('club_id_away', $clubid);
    }

    /**
     * Scope fixtures to a specific club, where club is home team
     * @param $query
     * @param $clubid
     * @return mixed
     */
    public function scopeOfClubHome($query, $clubid)
    {
        return $query->where('club_id_home', $clubid);
    }

    /**
     * Scope fixtures to a specific club, where club is away team
     * @param $query
     * @param $clubid
     * @return mixed
     */
    public function scopeOfClubAway($query, $clubid)
    {
        return $query->where('club_id_away', $clubid);
    }

    /**
     * Scope a query of fixtures to only finished matches with a real result
     * @param $query
     * @return mixed
     */
    public function scopePlayed($query, $played = true)
    {
        // if played is set to false, then return fixtures that are not played
        return ($played ? $query->whereNotNull('goals_home')->whereNotNull('goals_away') : $query->whereNull('goals_home')->whereNull('goals_away'));
    }

    /**
     * Scope to rated matches
     * @param $query
     * @return mixed
     */
    public function scopeRated($query)
    {
        return $query->whereNotNull('goals_home_rated')->whereNotNull('goals_away_rated');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePlayedOrRated($query)
    {
       return $query->whereNotNull('goals_home')->whereNotNull('goals_away')
           ->orWhere( function ($query) {
               return $query->whereNotNull('goals_home_rated')->whereNotNull('goals_away_rated');
           });
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotPlayedOrRated($query)
    {
        return $query->whereNull('goals_home')->whereNull('goals_away')->whereNull('goals_home_rated')->whereNull('goals_away_rated');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query, $published = true)
    {
        return $query->where('published', $published);
    }

    /**
     * Scope the query to uncancelled fixtures, i.e. none of the related clubs has withdrawn from the competition
     * @param $query
     * @return mixed
     */
    public function scopeNotCancelled($query, $cancelled = false)
    {
        return $query->where('cancelled', $cancelled);
    }

    /**
     * Scope the fixtures to matches rescheduled by the specified club
     * @param $query
     * @param $clubid
     * @return mixed
     */
    public function scopeRescheduledByClub($query, $clubid)
    {
        return $query->where('rescheduled_by_club', $clubid);
    }

    /**
     * Scope the query to fixtures that count for the table calculation
     * @param $query
     * @param bool $counts
     * @return mixed
     */
    public function scopeCountsInTables($query, $counts = true)
    {
        return $query->where('counts_in_tables', $counts);
    }

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * Check whether the match is finished and has a real result
     * @return bool
     */
    public function isPlayed()
    {
        if (isset($this->goals_home) && isset($this->goals_away)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @return bool
     */
    public function isPenalty()
    {
        if (isset($this->goals_home_11m) && isset($this->goals_away_11m)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check wether the match has been rated
     * @return bool
     */
    public function isRated()
    {
        if (isset($this->goals_home_rated) && isset($this->goals_away_rated)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check whether the macht has been cancelled
     * @return bool
     */
    public function isCancelled()
    {
        if ($this->cancelled) {
            return true;
        } else {
            return false;
        }
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * a fixture belongs to one matchweek
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matchweek()
    {
       return $this->belongsTo(Matchweek::class);
    }

    /**
     * a fixture has a stadium, a stadium is related to many fixtures
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    /**
     * A fixture belongs to one "home" club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clubHome()
    {
        return $this->belongsTo(Club::class, 'club_id_home');
    }

    /**
     * A fixture belongs to one "away" club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clubAway()
    {
        return $this->belongsTo(Club::class, 'club_id_away');
    }

    /**
     * A fixture can have one parent fixture it has been rescheduled from
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rescheduledFrom()
    {
        return $this->belongsTo(Fixture::class, 'rescheduled_from_fixture_id');
    }

    /**
     * A fixture can have one child fixture it has been rescheduled to
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rescheduledTo()
    {
        return $this->hasOne(Fixture::class, 'rescheduled_from_fixture_id');
    }

    /**
     * The club that cancelled the match
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rescheduledBy()
    {
        return $this->belongsTo(Club::class, 'rescheduled_by_club');
    }

    /**
     * Cards of a match
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Goals of a match
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Referees assigned to a match
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function referees()
    {
        return $this->belongsToMany(Referee::class, 'fixtures_referees')
            ->withPivot('note')
            ->withTimestamps();
    }
}
