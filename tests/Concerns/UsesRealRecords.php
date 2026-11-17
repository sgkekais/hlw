<?php

namespace Tests\Concerns;

use HLW\Card;
use HLW\Competition;
use HLW\Contact;
use HLW\DivisionOfficial;
use HLW\Goal;
use HLW\Person;
use HLW\Position;
use HLW\Referee;
use HLW\Season;
use HLW\Stadium;
use HLW\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Fills route parameters with real records of the local copy of the production database.
 */
trait UsesRealRecords
{
    private $params;

    protected function fillParameters($uri)
    {
        $params = $this->parameters();

        $url = preg_replace_callback('/\{(\w+)\??\}/', function ($m) use ($params) {
            return array_key_exists($m[1], $params) && $params[$m[1]] !== null ? $params[$m[1]] : '__missing__';
        }, $uri);

        return strpos($url, '__missing__') === false ? '/' . ltrim($url, '/') : null;
    }

    /**
     * Route parameter values taken from one consistent set of real records:
     * a fixture of the current season with goals, cards and referees.
     */
    protected function parameters()
    {
        if ($this->params !== null) {
            return $this->params;
        }

        $season = Season::current()->whereHas('fixtures.goals')->orderBy('id', 'desc')->first()
            ?: Season::whereHas('fixtures.goals')->orderBy('id', 'desc')->firstOrFail();

        $fixture = $season->fixtures()->has('goals')->has('cards')->has('referees')->orderBy('datetime', 'desc')->first()
            ?: $season->fixtures()->has('goals')->orderBy('datetime', 'desc')->firstOrFail();

        $club = $fixture->clubHome;
        $player = $club->players()->first();

        return $this->params = [
            'season'             => $season->id,
            'division'           => $season->division_id,
            'competition'        => optional($season->division)->competition_id ?: optional(Competition::first())->id,
            'matchweek'          => $fixture->matchweek_id,
            'fixture'            => $fixture->id,
            'club'               => $club->id,
            'player'             => optional($player)->id,
            'person'             => optional(optional($player)->person)->id ?: optional(Person::first())->id,
            'contact'            => optional($club->contacts()->first() ?: Contact::first())->id,
            'stadium'            => optional($club->stadiums()->first() ?: Stadium::first())->id,
            'referee'            => optional($fixture->referees()->first() ?: Referee::first())->id,
            'card'               => optional($fixture->cards()->first() ?: Card::first())->id,
            'goal'               => optional($fixture->goals()->first() ?: Goal::first())->id,
            'position'           => optional(Position::first())->id,
            'divisions_official' => optional(DivisionOfficial::first())->id,
            'user'               => optional(User::first())->id,
            'role'               => optional(Role::first())->id,
            'permission'         => optional(Permission::first())->id,
        ];
    }
}
