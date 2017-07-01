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

    public function position(){
        $this->belongsTo(Position::class);
    }
}
