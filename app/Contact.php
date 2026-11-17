<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Contact
 *
 * @property int $id
 * @property int $club_id
 * @property int $person_id
 * @property int|null $hierarchy_level
 * @property string|null $mail
 * @property string|null $mobile
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \HLW\Club $club
 * @property-read \HLW\Person $person
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereHierarchyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Contact whereUpdatedAt($value)
 */

class Contact extends Model
{
    use LogsActivity;

    /**
     * The attributes that are logged, only when they changed.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'hierarchy_level',
                'mail',
                'mobile',
            ])
            ->logOnlyDirty();
    }

    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'club_id', 'person_id', 'hierarchy_level', 'mail', 'mobile'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /***********************************************************
     * FUNCTIONS
     ************************************************************/

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
