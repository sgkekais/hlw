<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Card
 *
 * @property int $id
 * @property int $fixture_id
 * @property int $player_id
 * @property string $color
 * @property int|null $ban_matches
 * @property int|null $ban_reduced_by
 * @property bool $ban_season
 * @property bool $ban_lifetime
 * @property string|null $ban_reason
 * @property string|null $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \HLW\Fixture $fixture
 * @property-read \HLW\Player $player
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card ofSeason($season)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card reds()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereBanLifetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereBanMatches($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereBanReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereBanReducedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereBanSeason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereFixtureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card yellowReds()
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Card yellows()
 */

class Card extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'fixture_id',
        'player_id',
        'color',
        'ban_matches',
        'ban_reduced_by',
        'ban_season',
        'ban_lifetime',
        'ban_reason',
        'note'
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
        'player_id', 'color', 'ban_matches', 'ban_reduced_by', 'ban_season', 'ban_lifetime', 'ban_reason', 'note'
    ];

    protected $casts = [
        'ban_season'    => 'boolean',
        'ban_lifetime'  => 'boolean'
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
        return $query->where('color', 'red');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeYellows ($query)
    {
        return $query->where('color', 'yellow');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeYellowReds ($query)
    {
        return $query->where('color', 'yellow-red');
    }

    /**
     * Scope query to lifetime bans only
     * @param $query
     * @return mixed
     */
    public function scopeLifetimeBan ($query)
    {
        return $query->where('ban_lifetime', true);
    }

    /***********************************************************
     * ACCESSORS
     ************************************************************/

    public function getColorAttribute($value)
    {
        if ($value == "yellow") {
            return "gelb";
        } elseif ($value == "yellow-red") {
            return "gelb-rot";
        } elseif ($value == "red") {
            return "rot";
        } else {
            return $value;
        }
    }

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
