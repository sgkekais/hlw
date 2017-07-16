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
        'datetime',
        'stadium_id',
        'club_id_home',
        'club_id_away',
        'goals_home',
        'goals_away',
        'goals_home_11m',
        'goals_away_11m',
        'goals_home_rated', 'goals_away_rated', 'rated_note',
        'note',
        'cancelled',
        'published',
        'rescheduled_from_fixture_id',
        'rescheduled_by_club',
        'reschedule_reason'
    ];

    /**
     * Only the changed attributes should be logged
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'datetime',
        'stadium_id',
        'club_id_home',
        'club_id_away',
        'goals_home',
        'goals_away',
        'goals_home_11m',
        'goals_away_11m',
        'goals_home_rated', 'goals_away_rated', 'rated_note',
        'note',
        'cancelled',
        'published',
        'rescheduled_from_fixture_id',
        'rescheduled_by_club',
        'reschedule_reason'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = [
        'datetime'
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

    /**
     * A fixture belongs to one "home" club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club_home()
    {
        return $this->belongsTo(Club::class, 'club_id_home');
    }

    /**
     * A fixture belongs to one "away" club
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club_away()
    {
        return $this->belongsTo(Club::class, 'club_id_away');
    }

    /**
     * A fixture can have one parent fixture it has been rescheduled from
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rescheduled_from()
    {
        return $this->belongsTo(Fixture::class, 'rescheduled_from_fixture_id');
    }

    /**
     * A fixture can have one child fixture it has been rescheduled to
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rescheduled_to()
    {
        return $this->hasOne(Fixture::class, 'rescheduled_from_fixture_id');
    }

    /**
     * The club that cancelled the match
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rescheduled_by()
    {
        return $this->belongsTo(Club::class, 'rescheduled_by_club');
    }

    /**
     * Cards of a match
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
