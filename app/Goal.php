<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * HLW\Goal
 *
 * @property int $id
 * @property int $fixture_id
 * @property int $player_id
 * @property string|null $score
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \HLW\Fixture $fixture
 * @property-read \HLW\Player $player
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Goal whereFixtureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Goal wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Goal whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\HLW\Goal whereUpdatedAt($value)
 */

class Goal extends Model
{
    use LogsActivity;

    /**
     * The attributes that are logged, only when they changed.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'fixture_id',
                'player_id',
                'score',
            ])
            ->logOnlyDirty();
    }

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'player_id', 'score'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A goal belongs to a fixture
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    /**
     * A goal belongs to a player
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
