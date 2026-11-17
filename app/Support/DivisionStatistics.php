<?php

namespace HLW\Support;

use HLW\Card;
use HLW\Division;
use HLW\Player;
use HLW\Season;
use Illuminate\Support\Collection;

/**
 * Scorers and sinners of a division, used by the public pages (when personal
 * data is public, see config/hlw.php) and by the admin area.
 */
class DivisionStatistics
{
    /**
     * The given season of the division, else the current one, else the last one.
     */
    public static function season(Division $division, $seasonId = null): ?Season
    {
        if ($seasonId) {
            return $division->seasons()->find($seasonId);
        }

        return $division->seasons()->current()->first()
            ?: $division->seasons()->orderBy('season_nr', 'desc')->first();
    }

    /**
     * Players with a goals attribute, one entry per player with goals in the season.
     */
    public static function scorers(?Season $season): Collection
    {
        $scorers = collect();

        if (!$season) {
            return $scorers;
        }

        $season->load('matchweeks.fixtures.goals');
        foreach ($season->goals()->groupBy('player.id') as $index => $player_goals) {
            // get the player and load the person relationship
            $player = Player::with('person', 'club')->find($index);
            if (!$player) {
                continue;
            }
            // add a goals attribute
            $player->goals = $player_goals->count();
            $scorers->push($player);
        }

        return $scorers;
    }

    /**
     * Cards of the season and the cards of other seasons of the division
     * (without lifetime bans), both newest first.
     */
    public static function sinners(Division $division, ?Season $season): array
    {
        $cards = collect();

        if ($season) {
            $season->load('matchweeks.fixtures.cards');
            $cards = $season->cards()->sortByDesc('fixture.datetime');
        }

        $cards_from_other_season_or_division = $division->cards
            ->where('ban_lifetime', '!=', 1)
            ->where('fixture.matchweek.season.id', '!=', optional($season)->id)
            ->sortByDesc('fixture.datetime');

        return [$cards, $cards_from_other_season_or_division];
    }

    /**
     * Cards with a lifetime ban, of all divisions.
     */
    public static function lifetimeBans(): Collection
    {
        return Card::lifetimeBan()->get();
    }
}
