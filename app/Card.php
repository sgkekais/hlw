<?php

namespace App;

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
        'fixture_id', 'club_id', 'person_id', 'color', 'ban_matches', 'ban_season', 'ban_lifetime', 'note'
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
        'color', 'ban_matches', 'ban_season', 'ban_lifetime', 'note'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class,'id');
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }
}
