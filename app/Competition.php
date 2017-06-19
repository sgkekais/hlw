<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Competition extends Model
{
    use LogsActivity;

    // log attributes
    protected static $logAttributes = [
        'name', 'published'
    ];

    // Mass assignable fields
    protected $fillable = [
        'name', 'published'
    ];

    /**
     * @return User created_by
     */
    public function createdBy(){
        $created_by = Activity::where([
            ['description', 'created'],
            ['subject_id', $this->id],
            ['subject_type', 'App\Competition']
        ])->orderBy('created_at','asc')->first()->causer;

        return $created_by;
    }

    public function changedBy(){
        $changed_by = Activity::where([
            ['description', 'updated'],
            ['subject_id', $this->id],
            ['subject_type', 'App\Competition']
        ])->orderBy('updated_at','asc')->first()->causer;

        return $changed_by;
    }

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
