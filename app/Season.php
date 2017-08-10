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

        foreach ($this->clubs->sortBy('name') as $club) {
            // only clubs that have not withdrawn from the competition
            if (!$club->pivot->withdrawal) {

            }
        }
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
