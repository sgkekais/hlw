<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Division extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'competition_id', 'hierarchy_level', 'published'
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
        'name', 'competition_id', 'hierarchy_level', 'published'
    ];

    /**
     * Relationship
     * 1. Inverse One-to-Many
     * - a division belongs to one competition
     * - many divisions belong to one competition
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition(){
        return $this->belongsTo(Competition::class);
    }

    /**
     * Relationship
     * 2. One-to-Many
     * - a division has many seasons
     * - (many) seasons belong to one division
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seasons(){
        return $this->hasMany(Season::class);
    }
}
