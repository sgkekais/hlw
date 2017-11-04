<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Division
 *
 * @property int $id
 * @property int $competition_id
 * @property string $name
 * @property int $hierarchy_level
 * @property bool $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \HLW\Competition $competition
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Season[] $seasons
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division published()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division whereCompetitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division whereHierarchyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Division whereUpdatedAt($value)
 */

class Division extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'competition_id', 'hierarchy_level', 'published'
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
        'name', 'competition_id', 'hierarchy_level', 'published'
    ];

    /**
     * The attributes that should be casted to native types.
     * @var array
     */
    protected $casts = [
        'published' => 'boolean'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope a query to only published divisions
     * @param $query
     * @return mixed
     */
    public function scopePublished ($query)
    {
        return $query->where('published', 1);
    }

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /**
     * Return all divisions above the current one
     * @return mixed
     */
    public function higherDivisions()
    {
        return $this->competition->divisions->where('hierarchy_level', $this->hierarchy_level - 1);
    }

    /**
     * Return all divisions below the current one
     * @return mixed
     */
    public function lowerDivisions()
    {
        return $this->competition->divisions->where('hierarchy_level', $this->hierarchy_level + 1);
    }

    /**
     * Return the current published season for the division
     * @return mixed
     */
    public function currentSeason()
    {
        return $this->seasons()->published()->current()->first();
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A division belongs to one competition
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * A division has many seasons
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}
