<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Person extends Model
{
    use LogsActivity;

    // log attributes
    protected static $logAttributes = [
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'registered_at_club'
    ];

    // Mass assignable fields
    protected $fillable = [
        'first_name', 'last_name',
        'date_of_birth', 'photo', 'registered_at_club'
    ];

    public function players(){
        return $this->hasMany(Player::class);
    }

}
