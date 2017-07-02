<?php

namespace App;

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
        'date_of_birth', 'photo', 'registered_at_club'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'registered_at_club'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'date_of_birth'
    ];

    /**
     * A person can be one or many players at one or more clubs
     * A player is always one specific person
     * @return \Illuminate\Database\Eloquent\Relations\HasMany

    public function players(){
        return $this->hasMany(Player::class);
    }*/

    /**
     * A player is a person related to a club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs(){
        return $this->belongsToMany(Club::class, 'clubs_people')
            ->withPivot('sign_on','sign_off','number','position_id')
            ->withTimestamps()
            ->using(Player::class);
    }

    /**
     * Same as players relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referees(){
        return $this->hasMany(Referee::class);
    }

    /**
     * Same as players relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts(){
        return $this->hasMany(Contact::class);
    }
}
