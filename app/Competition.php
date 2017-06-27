<?php

namespace App;

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
        'name', 'published'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'published'
    ];

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
