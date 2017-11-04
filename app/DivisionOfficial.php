<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\DivisionOfficial
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_short
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Person[] $people
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\DivisionOfficial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\DivisionOfficial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\DivisionOfficial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\DivisionOfficial whereNameShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\DivisionOfficial whereUpdatedAt($value)
 */

class DivisionOfficial extends Model
{
    use LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'divisions_official';

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'name_short'
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
        'name', 'name_short'
    ];

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A official division has many players
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function people(){
        return $this->hasMany(Person::class, 'official_division_id');
    }
}
