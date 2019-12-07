<?php

require('../model/database.php');
require('../model/leagues_db.php');
require('../model/leaderboard_db.php');

$action = $action = filter_input(INPUT_GET, 'action');
if ($action == team) {
  $team_id = filter_input(INPUT_GET, 'team_id');
  $stat = filter_input(INPUT_GET, 'stat');
  $league = filter_input(INPUT_GET, 'league_id');
  if ($league === NULL || $league === FALSE) {
    $league = 1;
  }
  if ($stat == NULL || $stat == FALSE) {
    $stat = "Avg";
  }
  if (isset($team_id)) {
    $team_all_time_b_leaders = team_all_time_b_leaders($team_id, $stat);
  }
  $leagues = get_leagues();
  $teams = get_teams($league);
  $b_stat_names = b_stat_names();
  include('team_leaders.php');
}

 ?>
