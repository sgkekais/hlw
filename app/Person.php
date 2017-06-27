<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Person extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'registered_at_club'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'registered_at_club'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'date_of_birth'
    ];

    public function players(){
        return $this->hasMany(Player::class);
    }

}
