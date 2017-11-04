<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Referee
 *
 * @property int $id
 * @property int $person_id
 * @property string|null $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Fixture[] $fixtures
 * @property-read \HLW\Person $person
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Referee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Referee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Referee whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Referee wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Referee whereUpdatedAt($value)
 */

class Referee extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'person_id', 'note'
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
        'person_id', 'note'
    ];

    /*******************************************************
     * RELATIONSHIPS
     * ******************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fixtures()
    {
        return $this->belongsToMany(Fixture::class, 'fixtures_referees')
            ->withPivot('note')
            ->withTimestamps();
    }

}
