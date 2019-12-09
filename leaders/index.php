<?php
  require('../model/database.php');
  require('../model/leagues_db.php');
  require('../model/leaderboard_db.php');

  $action = filter_input(INPUT_GET, 'action');
  if ($action == NULL || $action == FALSE) {
    $action = 'team';
  }
  if ($action == team) {
    $team_id = filter_input(INPUT_GET, 'team_id');
    $stat = filter_input(INPUT_GET, 'stat');
    $league = filter_input(INPUT_GET, 'league_id');
    if ($league === NULL || $league === FALSE) {
     $league = 0;
    }
    if ($stat == NULL || $stat == FALSE) {
      $stat = "Avg";
    }
    if (isset($team_id)) {
      $team_all_time_b_leaders = team_all_time_b_leaders($team_id, $stat);
    }
  }
    $leagues = get_leagues();
    $teams = get_teams($league);
    $b_stat_names = ['G', 'AB', 'R', 'H', '2B', '3B', 'HR', 'RBI', 'BB', 'SO', 'SB', 'CS', 'Avg', 'OBP', 'TB', 'SLG', 'OPS',
                            'HBP', 'IBB', 'SAC', 'SF', 'PA']; # Should I make this a function?

  include('team_leaders.php');
  include('team_leaders_var_test.php');
 ?>
