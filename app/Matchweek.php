<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Matchweek extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged
     * @var array
     */
    protected static $logAttributes = [
        'number_consecutive', 'name', 'begin', 'end', 'published'
    ];

    /**
     * Only the changed attributes should be logged
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'number_consecutive', 'name', 'begin', 'end', 'published'
    ];

    /**
     * The attributes that should be mutated to dates
     * @var array
     */
    protected $dates = [
        'begin', 'end'
    ];

    /**
     * Scope the query to the current matchweek
     * @param $query
     * @return mixed
     */
    public function scopeCurrent($query)
    {
        return $query->where('begin', '<=', date('Y-m-d'))
            ->where('end', '>=', date('Y-m-d'))
            ->first();
    }

    /**
     * Relationship
     * 1. One-to-Many
     * - a matchweek belongs to one season
     * - a season has many matchweeks
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season(){
        return $this->belongsTo(Season::class);
    }

    /**
     * Relationship
     * 2. One-to-Many
     * - a matchweek has many fixtures
     * - a fixture / match belongs to one matchweek
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixtures(){
        return $this->hasMany(Fixture::class);
    }
}
