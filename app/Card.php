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

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * @param $query
     * @return mixed
     */
    public function scopeReds ($query)
    {
        return $query->where('color', 'Rot');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeYellows ($query)
    {
        return $query->where('color', 'Gelb');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeYellowReds ($query)
    {
        return $query->where('color', 'Gelb/Rot');
    }

    /**
     * TODO: cards of the current season
     * @param $query
     * @param $season
     */
    public function scopeOfSeason ($query, $season)
    {

    }

    /***********************************************************
     * SCOPES
     ************************************************************/

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A card belongs to a player
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * A card belongs to a fixture
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }
}
