<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Matchweek
 *
 * @property int $id
 * @property int $season_id
 * @property int|null $number_consecutive
 * @property string|null $name
 * @property \Carbon\Carbon|null $begin
 * @property \Carbon\Carbon|null $end
 * @property bool $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Fixture[] $fixtures
 * @property-read \HLW\Season $season
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek current()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek published()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereNumberConsecutive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Matchweek whereUpdatedAt($value)
 */

class Matchweek extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged
     * @var array
     */
    protected static $logAttributes = [
        'number_consecutive', 'name', 'begin', 'end', 'published'
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
        'number_consecutive', 'name', 'begin', 'end', 'published'
    ];

    /**
     * The attributes that should be mutated to dates
     * @var array
     */
    protected $dates = [
        'begin', 'end'
    ];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'published'     => 'boolean'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope the query to the current matchweek
     * @param $query
     * @return mixed
     */
    public function scopeCurrent($query)
    {
        return $query->where('begin', '<=', date('Y-m-d'))
            ->where('end', '>=', date('Y-m-d'));
    }

    /**
     * Scope the query to published matchweeks
     * @param $query
     * @return mixed
     *
     */
    public function scopePublished($query)
    {
        return $query->where('published', '1');
    }

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * Find the previous matchweek or return null
     * @return Matchweek $previous_mw|null
     */
    public function previousMatchweek()
    {
        $previous_mw = $this->season->matchweeks->where('number_consecutive', $this->number_consecutive - 1)->first();

        if ($previous_mw->count()) {
           return $previous_mw;
        } else {
            return null;
        }
    }

    /**
     * Find the next matchweek or return null
     * @return Matchweek $next_mw|null
     */
    public function nextMatchweek()
    {
        $next_mw = $this->season->matchweeks->where('number_consecutive', $this->number_consecutive + 1)->first();

        if ($next_mw->count()) {
            return $next_mw;
        } else {
            return null;
        }
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * - a matchweek belongs to one season
     * - a season has many matchweeks
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * - a matchweek has many fixtures
     * - a fixture / match belongs to one matchweek
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixtures()
    {
        return $this->hasMany(Fixture::class);
    }
}
