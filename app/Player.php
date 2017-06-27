<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Player extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'sign_on', 'sign_off',
        'number'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'sign_on', 'sign_off',
        'number'
    ];

    /**
     * - A "Player" is actually one specific person that can be other things, too
     * - A Person can be many players at different clubs (but not at the same time)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(){
        return $this->belongsTo(Person::class);
    }

    /**
     * - A player belongs to one club (with sign on and sign off date)
     * - A club has many players
     * - If a player transfers to another club, it's the person that transfers -> new entry into players table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club(){
        return $this->belongsTo(Club::class);
    }

    /**
     * For now, just one position from positions table
     * - A player has one position
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(){
        return $this->belongsTo(Position::class);
    }


}
