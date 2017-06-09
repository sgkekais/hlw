<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    // mass assignable fields
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
        'rescheduled_from_fixtures_id',
        'rescheduled_to_fixtures_id'
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
    public function stadium(){
        return $this->belongsTo(Stadium::class);
    }

    // TODO: rescheduled relationships
}
