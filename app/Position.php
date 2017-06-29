<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Position extends Model
{
    // TODO: Art der position hinzufügen (Spieler, Stab, ?)

    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * A position has many players who have that position
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players(){
        return $this->hasMany(Player::class);
    }
}
