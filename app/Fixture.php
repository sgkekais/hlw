<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Fixture extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged
     * @var array
     */
    protected static $logAttributes = [
        'date',
        'time',
        'stadium_id',
        'club_id_home',
        'club_id_away',
        'goals_home',
        'goals_away',
        'goals_home_11m',
        'goals_away_11m',
        'goals_home_rated',
        'goals_away_rated',
        'note',
        'cancelled',
        'published',
        'rescheduled_from_fixtures_id',
        'rescheduled_to_fixtures_id',
        'rescheduled_by_club'
    ];

    /**
     * The attributes that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'stadium_id',
        'club_id_home',
        'club_id_away',
        'goals_home',
        'goals_away',
        'goals_home_11m',
        'goals_away_11m',
        'goals_home_rated',
        'goals_away_rated',
        'note',
        'cancelled',
        'published',
        'rescheduled_from_fixtures_id',
        'rescheduled_to_fixtures_id',
        'rescheduled by club'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'date'
    ];

    /**
     * Relationship
     * 1. One-to-Many
     * - a fixture / match belongs to one matchweek
     * - a matchweek has many fixtures
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matchweek(){
       return $this->belongsTo(Matchweek::class);
    }

    /**
     * Relationship
     * 2. One-to-Many
     * - a fixture has one stadium
     * - a stadium has many fixtures
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function club_home()
    {
        return $this->belongsTo(Club::class, 'club_id_home');
    }

    public function club_away()
    {
        return $this->belongsTo(Club::class, 'club_id_away');
    }
    // TODO: rescheduled relationships (from, to, by which club)
}
