<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged
     * @var array
     */
    protected static $logAttributes = [
        'hierarchy_level', 'mail', 'mobile'
    ];

    /**
     * Only changed attributes should be logged
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'club_id', 'person_id', 'hierarchy_level', 'mail', 'mobile'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
