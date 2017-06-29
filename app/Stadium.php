<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Stadium extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stadiums';

    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'name_short', 'gmaps', 'note', 'published'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'name_short', 'gmaps', 'note', 'published'
    ];

    public function clubs(){
        return $this->belongsToMany(Club::class, 'clubs_stadiums'); // TODO: CHECK
    }
}
