<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Person
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property \Carbon\Carbon|null $date_of_birth
 * @property string|null $photo
 * @property bool $photo_public
 * @property int|null $registered_at_club
 * @property int|null $official_division_id
 * @property string|null $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Contact[] $contacts
 * @property-read string $full_name
 * @property-read string $full_name_shortened
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Player[] $players
 * @property-read \HLW\Club|null $realClub
 * @property-read \HLW\DivisionOfficial|null $realDivision
 * @property-read \Illuminate\Database\Eloquent\Collection|\HLW\Referee[] $referees
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereOfficialDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person wherePhotoPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereRegisteredAtClub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Person whereUpdatedAt($value)
 */

class Person extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'first_name', 'last_name', 'date_of_birth', 'photo', 'photo_public', 'registered_at_club', 'official_division_id', 'note', 'active'
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
        'first_name', 'last_name', 'date_of_birth', 'photo', 'photo_public', 'registered_at_club', 'official_division_id', 'note', 'active'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'date_of_birth'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'photo_public'  => 'boolean',
        'active'        => 'boolean'
    ];

    /*******************************************************
     * ACCESSORS
     * ******************************************************/

    /**
     * Combine last und first name with comma
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->last_name.", ".$this->first_name;
    }

    /**
     * @return string
     */
    public function getFullNameShortenedAttribute()
    {
        return $this->last_name.", ".str_limit($this->first_name, 1, '.');
    }

    /*******************************************************
     * RELATIONSHIPS
     * ******************************************************/

    /**
     * A person can be many players for different clubs
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Same as players relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referees()
    {
        return $this->hasMany(Referee::class);
    }

    /**
     * Same as players relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function realClub()
    {
        return $this->belongsTo(Club::class, 'registered_at_club');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function realDivision()
    {
        return $this->belongsTo(DivisionOfficial::class, 'official_division_id');
    }
}
