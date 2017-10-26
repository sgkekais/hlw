<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Competition extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'type', 'published'
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
        'name', 'type', 'published'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope a query to return only published competitions
     * @param $query
     * @return mixed
     */
    public function scopePublished ($query)
    {
        return $query->where('published', '1');
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * Relationships
     * 1. One-to-Many
     * - a competition has many divisions
     * - many divisions belong to one competition
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function divisions(){
        return $this->hasMany(Division::class);
    }

}
