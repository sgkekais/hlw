<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Club extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'name_short', 'name_code',
        'logo_url',
        'founded', 'league_entry', 'league_exit',
        'colours_club', 'colours_kit',
        'website', 'facebook',
        'note', 'is_real_club', 'published'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'name_short', 'name_code',
        'logo_url',
        'founded', 'league_entry', 'league_exit',
        'colours_club', 'colours_kit',
        'website', 'facebook',
        'note', 'is_real_club', 'published'
    ];

    /**
     * Relationship
     * - a club has many players
     * - a player belongs to one club at a given time
     * @return \Illuminate\Database\Eloquent\Relations\HasMany

    public function players(){
        return $this->hasMany(Player::class);
    }*/

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players(){
        return $this->belongsToMany(Person::class, 'clubs_people')
            ->withPivot('sign_on','sign_off','number','position_id')
            ->withTimestamps()
            ->using(Player::class);
    }

    /**
     * A club is related to many seasons
     * A season is related to many clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seasons(){
        return $this->belongsToMany(Season::class, 'clubs_seasons'); // TODO: CHECK
    }

    /**
     * A club can be related to one or more stadiums
     * A stadium can be related to one or more clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stadiums(){
        return $this->belongsToMany(Stadium::class, 'clubs_stadiums')
            ->withPivot('regular_home_day', 'regular_home_time', 'note', 'is_regular_stadium')
            ->withTimestamps(); // TODO: CHECK, works with $club->stadiums()->save($stadium)!
    }

    // TODO: more relationships, e.g. fixtures (home, away, all, create function in controller that uses relationship in combination with year)
    // TODO: rescheduled by club
}
