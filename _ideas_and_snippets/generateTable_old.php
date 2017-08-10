public function generateTable(Matchweek $matchweek = null) {
    if (is_null($matchweek)) {
            $matchweek = $this->currentMatchweek();
        }

        // get all clubs assigned to this season
        $clubs = $this->clubs->sortBy('name');

        /*
         * Create initial table
         * Rank Played Won Drawn Loss GoalsFor GoalsAgainst GoalDifference Points Form...
         */
        $table = $clubs->map(function ($club) {
            $club['t_rank']         = 0;
            $club['t_played']       = 0;
            $club['t_won']          = 0;
            $club['t_drawn']        = 0;
            $club['t_lost']         = 0;
            $club['t_goals_for']    = 0;
            $club['t_goals_against']= 0;
            $club['t_goals_diff']   = 0;
            $club['t_points']       = 0;

            return $club;
        });

        // #1 Collect the data
        foreach ($table as $club) {
            // only clubs that have not withdrawn from the competition
            if (!$club->pivot->withdrawal) {
                // get all played fixtures of the current club of this season
                // count only fixtures where related clubs have not withdrawn from the competition -> notCancelled
                $club_fixtures_played = $this->fixtures()->played()->notCancelled()->ofClub($club->id)->get();
                // get all rated fixtures ""
                $club_fixtures_rated  = $this->fixtures()->rated()->notCancelled()->ofClub($club->id)->get();
                // merge
                $club_fixtures = $club_fixtures_played->merge($club_fixtures_rated)->sortBy('matchweek.number_consecutive');

                foreach ($club_fixtures as $fixture) {
                    // aggregate values only until current matchweek
                    if ($fixture->matchweek->number_consecutive <= $matchweek->number_consecutive) {
                        // increment games played
                        $club->t_played++;
                        // won, drawn, loss, points
                        // not rated
                        if($fixture->isPlayed() && !$fixture->isRated()){
                            if ($club->id == $fixture->club_id_home && ($fixture->goals_home > $fixture->goals_away)
                                || $club->id == $fixture->club_id_away && ($fixture->goals_home < $fixture->goals_away)) {
                                $club->t_won++;
                                $club->t_points += 3;
                            } elseif ($fixture->goals_home == $fixture->goals_away) {
                                $club->t_drawn++;
                                $club->t_points += 1;
                            } else {
                                $club->t_lost++;
                            }
                            // goals for and against
                            if ($club->id == $fixture->club_id_home) {
                                $club->t_goals_for += $fixture->goals_home;
                                $club->t_goals_against += $fixture->goals_away;
                            } elseif ($club->id == $fixture->club_id_away) {
                                $club->t_goals_for += $fixture->goals_away;
                                $club->t_goals_against += $fixture->goals_home;
                            }
                        } elseif ($fixture->isRated()) { // rated match
                            if ($club->id == $fixture->club_id_home && ($fixture->goals_home_rated > $fixture->goals_away_rated)
                                || $club->id == $fixture->club_id_away && ($fixture->goals_home_rated < $fixture->goals_away_rated)) {
                                $club->t_won++;
                                $club->t_points += 3;
                            } elseif ($fixture->goals_home_rated == $fixture->goals_away_rated) {
                                $club->t_drawn++;
                                $club->t_points += 1;
                            } else {
                                $club->t_lost++;
                            }
                            // goals for and against
                            if ($club->id == $fixture->club_id_home) {
                                $club->t_goals_for += $fixture->goals_home_rated;
                                $club->t_goals_against += $fixture->goals_away_rated;
                            } elseif ($club->id == $fixture->club_id_away) {
                                $club->t_goals_for += $fixture->goals_away_rated;
                                $club->t_goals_against += $fixture->goals_home_rated;
                            }
                        }

                    }
                }
                // goals difference
                $club->t_goals_diff = $club->t_goals_for - $club->t_goals_against;
                // #2 Apply season parameters contained in pivot
                // points deduction
                $club->t_points -= $club->pivot->deduction_points;
                // goals deduction
                $club->t_goals_for -= $club->pivot->deduction_goals;
            }
        }

        // #3 Sort the table, use values() on collection
        $table_sorted = $table->sort( function($a, $b) {
            $result = false;

            // compare points
            if ($b->t_points > $a->t_points) {
                $result = true;
            } elseif ($b->t_points == $a->t_points) {               // if points are equal
                if ($b->t_goals_diff > $a->t_goals_diff) {          // compare goal difference
                    $result = true;
                } elseif ($b->t_goals_diff == $a->t_goals_diff) {   // if goal difference is equal
                    if ($b->t_goals_for > $a->t_goals_for) {        // compare goals for
                        $result = true;
                    }
                }
            }

            return $result;

        })->values();

        // #4 calculate the rank
        $rank = 1;
        foreach ($table_sorted as $index => $club) {
            // first iteration
            if ($index === 0) {
                $club->t_rank = $rank;
                continue;
            }

            // break if only one item
            if ($table_sorted->count() == 1) {
                break;
            }

            // compare with previous club
            $club_previous = $table_sorted->get(--$index);
            // points
            if ($club->t_points < $club_previous->t_points) {
                $rank++;
                $club->t_rank = $rank;
                continue;
            } elseif ($club->t_points == $club_previous->t_points) {
                // equal points, then compare if goals difference smaller
                // equal goals diff, then compare goals for
                if ($club->t_goals_diff < $club_previous->t_goals_diff) {
                    $rank++;
                    $club->t_rank = $rank;
                    continue;
                } elseif (($club->t_goals_diff == $club_previous->t_goals_diff)
                    && ($club->t_goals_for < $club_previous->t_goals_for)) {
                        $rank++;
                        $club->t_rank = $rank;
                        continue;
                } else {
                    $club->t_rank = $rank;
                    continue;
                }
            }
        }

        return $table_sorted;
}
