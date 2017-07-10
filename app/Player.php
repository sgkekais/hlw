<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\Traits\LogsActivity;

class Player extends Pivot
{
   use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'sign_on', 'sign_off', 'number', 'position_id'
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
        'sign_on', 'sign_off', 'number', 'position_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'sign_on', 'sign_off'
    ];

    /*******************************************************
     * SCOPES
     * ******************************************************/

    /**
     * Scope a query to only include active players (sign_off == null)
     * @param $query
     * @return mixed
     */
    public function scopeActive($query){
        return $query->whereNull('sign_off');
    }

    /**
     * Scope a query to only include inactive players (sign_off == null)
     * @param $query
     * @return mixed
     */
    public function scopeInactive($query){
        return $query->whereNotNull('sign_off');
    }

    /*******************************************************
     * RELATIONSHIPS
     * ******************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(){
        return $this->belongsTo(Position::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(){
        return $this->belongsTo(Person::class);
    }
}
