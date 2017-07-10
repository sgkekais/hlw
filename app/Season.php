<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Season extends Model
{
    use LogsActivity;

    // log attributes
    protected static $logAttributes = [
        'division_id',
        'year_begin', 'year_end',
        'season_nr',
        'champion',
        'ranks_champion', 'ranks_promotion', 'ranks_relegation',
        'playoff_champion', 'playoff_cup', 'playoff_relegation',
        'max_rescheduling',
        'rules',
        'note',
        'published'
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
        'division_id',
        'year_begin', 'year_end',
        'season_nr',
        'champion',
        'ranks_champion', 'ranks_promotion', 'ranks_relegation',
        'playoff_champion', 'playoff_cup', 'playoff_relegation',
        'max_rescheduling',
        'rules',
        'note',
        'published'
    ];

    /**
     * Relationship
     * 1. One-to-Many
     * - a division has many seasons
     * - a season belongs to one division
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(){
        return $this->belongsTo(Division::class);
    }

    /**
     * Relationship
     * 2. One-to-Many
     * - a season has many matchweeks
     * - a matchweek belongs to one season
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matchweeks(){
        return $this->hasMany(Matchweek::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clubs(){
        return $this->belongsToMany(Club::class, 'clubs_seasons')
            ->withPivot('rank', 'deduction_points', 'deduction_goals', 'withdrawal', 'note')
            ->withTimestamps();

    }
}
