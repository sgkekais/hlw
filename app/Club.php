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
     */
    public function players(){
        return $this->hasMany(Player::class);
    }

    public function seasons(){
        return $this->belongsToMany(Season::class, 'clubs_seasons'); // TODO: CHECK
    }

    public function stadiums(){
        return $this->belongsToMany(Stadium::class, 'clubs_stadiums'); // TODO: CHECK
    }

    // TODO: more relationships, e.g. fixtures (home, away, all, create function in controller that uses relationship in combination with year)
    // TODO: rescheduled by club
}
