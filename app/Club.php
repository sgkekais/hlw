<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Club extends Model
{
    use LogsActivity;

    /**
     * The attributes that should be logged.
     * @var array
     */
    protected static $logAttributes = [
        'name', 'name_short', 'name_code',
        'founded', 'league_entry', 'league_exit',
        'colours_club_primary', 'colours_club_secondary',
        'colours_kit_home_primary', 'colours_kit_home_secondary',
        'colours_kit_away_primary', 'colours_kit_away_secondary',
        'website', 'facebook',
        'note', 'is_real_club', 'published'
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
        'name', 'name_short', 'name_code',
        'founded', 'league_entry', 'league_exit',
        'colours_club_primary', 'colours_club_secondary',
        'colours_kit_home_primary', 'colours_kit_home_secondary',
        'colours_kit_away_primary', 'colours_kit_away_secondary',
        'website', 'facebook',
        'note', 'is_real_club', 'published'
    ];

    /***********************************************************
     * SCOPES
     ************************************************************/

    /**
     * Scope a query to only include hobby clubs
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsNotRealClub($query)
    {
        return $query->where('is_real_club','0');
    }

    /**
     * Scope a query to only include real clubs
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsRealClub($query)
    {
        return $query->where('is_real_club','1');
    }

    /**
     * Get all matches the club is related to
     * TODO: add parameters to scope query, e.g. only matches of current season
     * @return mixed
     */
    public function getFixtures()
    {
        $fixtures = Fixture::where('club_id_home', $this->id)
            ->orWhere('club_id_away', $this->id)
            ->get();

        return $fixtures;
    }

    /***********************************************************
     * RELATIONSHIPS
     ************************************************************/

    /**
     * A club has many players
     * A player can be related to many clubs (though not at the same time)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players()
    {
        return $this->belongsToMany(Person::class, 'clubs_people')
            ->withPivot('sign_on','sign_off','number','position_id')
            ->withTimestamps()
            ->using(Player::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * A club is related to many seasons
     * A season is related to many clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'clubs_seasons')
            ->withPivot('rank', 'deduction_points', 'deduction_goals', 'withdrawal', 'note')
            ->withTimestamps();
    }

    /**
     * A club can be related to one or more stadiums
     * A stadium can be related to one or more clubs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stadiums()
    {
        return $this->belongsToMany(Stadium::class, 'clubs_stadiums')
            ->withPivot('regular_home_day', 'regular_home_time', 'note', 'is_regular_stadium')
            ->withTimestamps(); // TODO: CHECK, works with $club->stadiums()->save($stadium)!
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixtures_home()
    {
        return $this->hasMany(Fixture::class, 'club_id_home');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fixtures_away()
    {
        return $this->hasMany(Fixture::class, 'club_id_away');
    }

    public function reschedulings()
    {
        return $this->hasMany(Fixture::class, 'rescheduled_by_club');
    }
}
