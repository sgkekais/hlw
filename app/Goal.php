<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Goal extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'fixture_id', 'player_id', 'score'
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
        'score'
    ];

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class); // doesn't work
    }
}
