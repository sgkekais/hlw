<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Position
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Player[] $players
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Position whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Position whereUpdatedAt($value)
 */

class Position extends Model
{
    use LogsActivity;

    /**
     * The attributes that are logged, only when they changed.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'type',
            ])
            ->logOnlyDirty();
    }

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'type'
    ];

    /*******************************************************
     * RELATIONSHIPS
     * ******************************************************/

    /**
     * A position has many players who have that position
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players(){
        return $this->hasMany(Player::class);
    }
}
