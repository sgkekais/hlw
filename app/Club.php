<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    // mass assignable fields
    protected $fillable = [
        'name', 'name_short', 'name_code',
        'logo_url',
        'founded', 'league_entry', 'league_exit',
        'colours_club', 'colours_kit',
        'website', 'facebook',
        'note'
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
        return $this->belongsToMany(Season::class); // TODO: CHECK
    }

    public function stadiums(){
        return $this->belongsToMany(Stadium::class); // TODO: CHECK
    }

    // TODO: more relationships, e.g. fixtures (home, away, all, create function in controller that uses relationship in combination with year)
}
