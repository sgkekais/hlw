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
     * Scope the query to published competitions
     * @param $query
     * @return mixed
     */
    public function scopePublished ($query)
    {
        return $query->where('published', '1');
    }

    /**
     * Scope the query to leagues
     * @param $query
     * @return mixed
     */
    public function scopeLeagues ($query)
    {
        return $query->where('type', 'league');
    }

    /**
     * Scope the query to knockout tournaments / 'cups'
     * @param $query
     * @return mixed
     */
    public function scopeKnockouts ($query)
    {
        return $query->where('type', 'knockout');
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
