<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Player
 *
 * @property int $id
 * @property int $club_id
 * @property int $person_id
 * @property \Carbon\Carbon $sign_on
 * @property \Carbon\Carbon|null $sign_off
 * @property string|null $number
 * @property int|null $position_id
 * @property bool $public
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Card[] $cards
 * @property-read \HLW\Club $club
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Goal[] $goals
 * @property-read \HLW\Person $person
 * @property-read \HLW\Position|null $position
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player active()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player public()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereClubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereSignOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereSignOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Player whereUpdatedAt($value)
 */

class Player extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'clubs_people';

   use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'person_id', 'sign_on', 'sign_off', 'number', 'position_id', 'public'
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
        'person_id', 'sign_on', 'sign_off', 'number', 'position_id', 'public'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'sign_on', 'sign_off'
    ];

    protected $casts = [
        'public' => 'boolean'
    ];

    /*******************************************************
     * SCOPES
     * ******************************************************/

    /**
     * Scope a query to only include active players (sign_off == null)
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->whereNull('sign_off');
    }

    /**
     * Scope a query to only include inactive players (sign_off == null)
     * @param $query
     * @return mixed
     */
    public function scopeInactive($query)
    {
        return $query->whereNotNull('sign_off');
    }

    /**
     * Scope a query to only include public players
     * @param $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->where('public', 1);
    }

    /*******************************************************
     * FUNCTIONS
     * ******************************************************/

    /**
     * Is this an active player?
     * @return bool
     */
    public function isActive()
    {
        if (!$this->sign_off) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * TODO
     */
    public function isSuspended()
    {



        $current_suspension = $this->cards()->get()->where();
    }

    /*******************************************************
     * RELATIONSHIPS
     * ******************************************************/

    /**
     * A player belongs to a club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * A player is a person
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(){
        return $this->belongsTo(Person::class);
    }

    /**
     * A player has a position
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(){
        return $this->belongsTo(Position::class);
    }

    /**
     * A player has many cards
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class, 'player_id');
    }

    /**
     * A player has many goals
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany(Goal::class, 'player_id');
    }
}
