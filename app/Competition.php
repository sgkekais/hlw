<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Models\Activity;
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

    /* replaced by helper function
    **
     * @return User created_by
     *
    public function createdBy(){
        $created_by = Activity::where([
            ['description', 'created'],
            ['subject_id', $this->id],
            ['subject_type', 'App\Competition']
        ])->orderBy('created_at','desc')->first();

        // did we find a log entry?
        if($created_by){
            // then return the user
            return $created_by->causer;
        }else{
            // else return null
            return $created_by;
        }
    }

    public function changedBy(){
        $changed_by = Activity::where([
            ['description', 'updated'],
            ['subject_id', $this->id],
            ['subject_type', 'App\Competition']
        ])->orderBy('updated_at','desc')->first();

        // did we find a log entry?
        if($changed_by){
            // then return the user
            return $changed_by->causer;
        }else{
            // else return null
            return $changed_by;
        }
    }
    */

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
