<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Stadium
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_short
 * @property string|null $gmaps
 * @property string|null $lat
 * @property string|null $long
 * @property string|null $note
 * @property bool $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Club[] $clubs
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium published()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereGmaps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereNameShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Stadium whereUpdatedAt($value)
 */

class Stadium extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stadiums';

    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'name_short', 'gmaps', 'lat', 'long', 'note', 'published'
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
        'name', 'name_short', 'gmaps', 'lat', 'long', 'note', 'published'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'published' => 'boolean'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A stadium can be related to many clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs(){
        return $this->belongsToMany(Club::class, 'clubs_stadiums')
            ->withPivot('regular_home_day', 'regular_home_time', 'note', 'is_regular_stadium')
            ->withTimestamps();
    }
}
