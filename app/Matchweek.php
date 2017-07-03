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
     * The attributes that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'number_consecutive', 'name', 'begin', 'end', 'published'
    ];

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
