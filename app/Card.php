<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Card extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'fixture_id', 'player_id', 'color', 'ban_matches', 'ban_season', 'ban_lifetime', 'ban_reason', 'note'
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
        'player_id', 'color', 'ban_matches', 'ban_season', 'ban_lifetime', 'ban_reason', 'note'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }
}
