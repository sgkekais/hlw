<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Person extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'photo_public', 'registered_at_club', 'note'
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
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'photo_public', 'registered_at_club', 'note'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'date_of_birth'
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
}
