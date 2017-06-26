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

    public function clubs(){
        return $this->belongsToMany(Club::class, 'clubs_stadiums'); // TODO: CHECK
    }
}
