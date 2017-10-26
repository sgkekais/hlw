<?php

namespace HLW;

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

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope a query to only published divisions
     * @param $query
     * @return mixed
     */
    public function scopePublished ($query)
    {
        return $query->where('published', 1);
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A division belongs to one competition
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competition(){
        return $this->belongsTo(Competition::class);
    }

    /**
     * A division has many seasons
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seasons(){
        return $this->hasMany(Season::class);
    }
}
