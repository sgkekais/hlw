<?php

namespace HLW;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Player extends Model
{
    /**
     * The table associated with the model
     * @var string
     */
    protected $table = 'clubs_people';

   use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'person_id', 'sign_on', 'sign_off', 'number', 'position_id', 'public'
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
        'person_id', 'sign_on', 'sign_off', 'number', 'position_id', 'public'
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
     * FUNCTIONS
     * ******************************************************/

    /**
     * @return bool
     */
    public function isActive()
    {
        if (!$this->sign_off) {
            return true;
        } else {
            return false;
        }
    }

    /*******************************************************
     * RELATIONSHIPS
     * ******************************************************/

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(){
        return $this->belongsTo(Person::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(){
        return $this->belongsTo(Position::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class, 'player_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany(Goal::class, 'player_id');
    }
}
